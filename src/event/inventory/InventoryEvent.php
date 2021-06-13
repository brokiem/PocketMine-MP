<?php

declare(strict_types=1);

/**
 * Inventory related events
 */
namespace pocketmine\event\inventory;

use pocketmine\event\Event;
use pocketmine\inventory\Inventory;
use pocketmine\player\Player;

abstract class InventoryEvent extends Event{
	/** @var Inventory */
	protected $inventory;

	public function __construct(Inventory $inventory){
		$this->inventory = $inventory;
	}

	public function getInventory() : Inventory{
		return $this->inventory;
	}

	/**
	 * @return Player[]
	 */
	public function getViewers() : array{
		return $this->inventory->getViewers();
	}
}
