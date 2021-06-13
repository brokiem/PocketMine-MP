<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\math\AxisAlignedBB;

abstract class Flowable extends Transparent{

	public function canBeFlowedInto() : bool{
		return true;
	}

	public function isSolid() : bool{
		return false;
	}

	/**
	 * @return AxisAlignedBB[]
	 */
	protected function recalculateCollisionBoxes() : array{
		return [];
	}
}
