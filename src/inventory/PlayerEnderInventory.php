<?php

declare(strict_types=1);

namespace pocketmine\inventory;

use pocketmine\entity\Human;

final class PlayerEnderInventory extends SimpleInventory{

	private Human $holder;

	public function __construct(Human $holder, int $size = 27){
		$this->holder = $holder;
		parent::__construct($size);
	}

	public function getHolder() : Human{ return $this->holder; }
}
