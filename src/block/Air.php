<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\math\AxisAlignedBB;

/**
 * Air block
 */
class Air extends Transparent{

	public function canBeFlowedInto() : bool{
		return true;
	}

	public function canBeReplaced() : bool{
		return true;
	}

	public function canBePlaced() : bool{
		return false;
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
