<?php

declare(strict_types=1);

namespace pocketmine\event\inventory;

use pocketmine\inventory\Inventory;
use pocketmine\player\Player;

class InventoryCloseEvent extends InventoryEvent{
	/** @var Player */
	private $who;

	public function __construct(Inventory $inventory, Player $who){
		$this->who = $who;
		parent::__construct($inventory);
	}

	public function getPlayer() : Player{
		return $this->who;
	}
}
