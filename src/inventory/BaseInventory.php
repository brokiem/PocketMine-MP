<?php

declare(strict_types=1);

namespace pocketmine\inventory;

use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use pocketmine\player\Player;
use pocketmine\utils\ObjectSet;
use function array_slice;
use function count;
use function spl_object_id;

/**
 * This class provides everything needed to implement an inventory, minus the underlying storage system.
 */
abstract class BaseInventory implements Inventory{
	use InventoryHelpersTrait;

	/** @var int */
	protected $maxStackSize = Inventory::MAX_STACK;
	/** @var Player[] */
	protected $viewers = [];
	/**
	 * @var InventoryListener[]|ObjectSet
	 * @phpstan-var ObjectSet<InventoryListener>
	 */
	protected $listeners;

	public function __construct(){
		$this->listeners = new ObjectSet();
	}

	public function getMaxStackSize() : int{
		return $this->maxStackSize;
	}

	/**
	 * @param Item[] $items
	 */
	abstract protected function internalSetContents(array $items) : void;

	/**
	 * @param Item[] $items
	 */
	public function setContents(array $items) : void{
		if(count($items) > $this->getSize()){
			$items = array_slice($items, 0, $this->getSize(), true);
		}

		$oldContents = $this->getContents(true);

		$listeners = $this->listeners->toArray();
		$this->listeners->clear();
		$viewers = $this->viewers;
		$this->viewers = [];

		$this->internalSetContents($items);

		$this->listeners->add(...$listeners); //don't directly write, in case listeners were added while operation was in progress
		foreach($viewers as $id => $viewer){
			$this->viewers[$id] = $viewer;
		}

		foreach($this->listeners as $listener){
			$listener->onContentChange($this, $oldContents);
		}

		foreach($this->getViewers() as $viewer){
			if($viewer->isConnected()){
				$viewer->getNetworkSession()->getInvManager()->syncContents($this);
			}
		}
	}

	abstract protected function internalSetItem(int $index, Item $item) : void;

	public function setItem(int $index, Item $item) : void{
		if($item->isNull()){
			$item = ItemFactory::air();
		}else{
			$item = clone $item;
		}

		$oldItem = $this->getItem($index);

		$this->internalSetItem($index, $item);
		$this->onSlotChange($index, $oldItem);
	}

	/**
	 * @return Player[]
	 */
	public function getViewers() : array{
		return $this->viewers;
	}

	/**
	 * Removes the inventory window from all players currently viewing it.
	 */
	public function removeAllViewers() : void{
		foreach($this->viewers as $hash => $viewer){
			if($viewer->getCurrentWindow() === $this){ //this might not be the case for the player's own inventory
				$viewer->removeCurrentWindow();
			}
			unset($this->viewers[$hash]);
		}
	}

	public function setMaxStackSize(int $size) : void{
		$this->maxStackSize = $size;
	}

	public function onOpen(Player $who) : void{
		$this->viewers[spl_object_id($who)] = $who;
	}

	public function onClose(Player $who) : void{
		unset($this->viewers[spl_object_id($who)]);
	}

	protected function onSlotChange(int $index, Item $before) : void{
		foreach($this->listeners as $listener){
			$listener->onSlotChange($this, $index, $before);
		}
		foreach($this->viewers as $viewer){
			if($viewer->isConnected()){
				$viewer->getNetworkSession()->getInvManager()->syncSlot($this, $index);
			}
		}
	}

	/**
	 * @param Item[] $itemsBefore
	 * @phpstan-param array<int, Item> $itemsBefore
	 */
	protected function onContentChange(array $itemsBefore) : void{
		foreach($this->listeners as $listener){
			$listener->onContentChange($this, $itemsBefore);
		}

		foreach($this->getViewers() as $viewer){
			$viewer->getNetworkSession()->getInvManager()->syncContents($this);
		}
	}

	public function slotExists(int $slot) : bool{
		return $slot >= 0 and $slot < $this->getSize();
	}

	public function getListeners() : ObjectSet{
		return $this->listeners;
	}
}
