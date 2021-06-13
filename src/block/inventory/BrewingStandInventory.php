<?php

declare(strict_types=1);

namespace pocketmine\block\inventory;

use pocketmine\inventory\SimpleInventory;
use pocketmine\world\Position;

class BrewingStandInventory extends SimpleInventory implements BlockInventory{
	use BlockInventoryTrait;

	public function __construct(Position $holder, int $size = 5){
		$this->holder = $holder;
		parent::__construct($size);
	}
}
