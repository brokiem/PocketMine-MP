<?php

declare(strict_types=1);

namespace pocketmine\block\inventory;

use pocketmine\world\Position;

trait BlockInventoryTrait{
	protected Position $holder;

	public function getHolder() : Position{
		return $this->holder;
	}
}
