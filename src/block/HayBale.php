<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\block\utils\PillarRotationInMetadataTrait;

class HayBale extends Opaque{
	use PillarRotationInMetadataTrait;

	public function getFlameEncouragement() : int{
		return 60;
	}

	public function getFlammability() : int{
		return 20;
	}
}
