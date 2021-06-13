<?php

declare(strict_types=1);

namespace pocketmine\event\player;

use pocketmine\event\Cancellable;
use pocketmine\event\CancellableTrait;
use pocketmine\item\Item;
use pocketmine\player\Player;

class PlayerItemHeldEvent extends PlayerEvent implements Cancellable{
	use CancellableTrait;

	/** @var Item */
	private $item;
	/** @var int */
	private $hotbarSlot;

	public function __construct(Player $player, Item $item, int $hotbarSlot){
		$this->player = $player;
		$this->item = $item;
		$this->hotbarSlot = $hotbarSlot;
	}

	/**
	 * Returns the hotbar slot the player is attempting to hold.
	 *
	 * NOTE: This event is called BEFORE the slot is equipped server-side. Setting the player's held item during this
	 * event will result in the **old** slot being changed, not this one.
	 *
	 * To change the item in the slot that the player is attempting to hold, set the slot that this function reports.
	 */
	public function getSlot() : int{
		return $this->hotbarSlot;
	}

	/**
	 * Returns the item in the slot that the player is trying to equip.
	 */
	public function getItem() : Item{
		return $this->item;
	}
}
