<?php

declare(strict_types=1);

namespace pocketmine\inventory;

use pocketmine\entity\Human;

final class PlayerOffHandInventory extends SimpleInventory{
	/** @var Human */
	private $holder;

	public function __construct(Human $player){
		$this->holder = $player;
		parent::__construct(1);
	}

	public function getHolder() : Human{ return $this->holder; }
}
