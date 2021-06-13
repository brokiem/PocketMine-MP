<?php

declare(strict_types=1);

namespace pocketmine\inventory;

use pocketmine\entity\Human;
use pocketmine\item\Item;
use pocketmine\player\Player;
use pocketmine\utils\ObjectSet;

class PlayerInventory extends SimpleInventory{

	/** @var Human */
	protected $holder;

	/** @var int */
	protected $itemInHandIndex = 0;

	/**
	 * @var \Closure[]|ObjectSet
	 * @phpstan-var ObjectSet<\Closure(int $oldIndex) : void>
	 */
	protected $heldItemIndexChangeListeners;

	public function __construct(Human $player){
		$this->holder = $player;
		$this->heldItemIndexChangeListeners = new ObjectSet();
		parent::__construct(36);
	}

	public function isHotbarSlot(int $slot) : bool{
		return $slot >= 0 and $slot <= $this->getHotbarSize();
	}

	/**
	 * @throws \InvalidArgumentException
	 */
	private function throwIfNotHotbarSlot(int $slot) : void{
		if(!$this->isHotbarSlot($slot)){
			throw new \InvalidArgumentException("$slot is not a valid hotbar slot index (expected 0 - " . ($this->getHotbarSize() - 1) . ")");
		}
	}

	/**
	 * Returns the item in the specified hotbar slot.
	 *
	 * @throws \InvalidArgumentException if the hotbar slot index is out of range
	 */
	public function getHotbarSlotItem(int $hotbarSlot) : Item{
		$this->throwIfNotHotbarSlot($hotbarSlot);
		return $this->getItem($hotbarSlot);
	}

	/**
	 * Returns the hotbar slot number the holder is currently holding.
	 */
	public function getHeldItemIndex() : int{
		return $this->itemInHandIndex;
	}

	/**
	 * Sets which hotbar slot the player is currently loading.
	 *
	 * @param int $hotbarSlot 0-8 index of the hotbar slot to hold
	 *
	 * @throws \InvalidArgumentException if the hotbar slot is out of range
	 */
	public function setHeldItemIndex(int $hotbarSlot) : void{
		$this->throwIfNotHotbarSlot($hotbarSlot);

		$oldIndex = $this->itemInHandIndex;
		$this->itemInHandIndex = $hotbarSlot;

		foreach($this->heldItemIndexChangeListeners as $callback){
			$callback($oldIndex);
		}
	}

	/**
	 * @return \Closure[]|ObjectSet
	 * @phpstan-return ObjectSet<\Closure(int $oldIndex) : void>
	 */
	public function getHeldItemIndexChangeListeners() : ObjectSet{ return $this->heldItemIndexChangeListeners; }

	/**
	 * Returns the currently-held item.
	 */
	public function getItemInHand() : Item{
		return $this->getHotbarSlotItem($this->itemInHandIndex);
	}

	/**
	 * Sets the item in the currently-held slot to the specified item.
	 */
	public function setItemInHand(Item $item) : void{
		$this->setItem($this->getHeldItemIndex(), $item);
	}

	/**
	 * Returns the number of slots in the hotbar.
	 */
	public function getHotbarSize() : int{
		return 9;
	}

	/**
	 * @return Human|Player
	 */
	public function getHolder(){
		return $this->holder;
	}
}
