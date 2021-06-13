<?php

declare(strict_types=1);

namespace pocketmine\block;

abstract class PressurePlate extends Transparent{

	public function isSolid() : bool{
		return false;
	}

	protected function recalculateCollisionBoxes() : array{
		return [];
	}

	//TODO
}
