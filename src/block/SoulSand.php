<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\math\AxisAlignedBB;
use pocketmine\math\Facing;

class SoulSand extends Opaque{

	/**
	 * @return AxisAlignedBB[]
	 */
	protected function recalculateCollisionBoxes() : array{
		return [AxisAlignedBB::one()->trim(Facing::UP, 1 / 8)];
	}
}
