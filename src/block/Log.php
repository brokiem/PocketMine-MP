<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\block\utils\PillarRotationInMetadataTrait;

class Log extends Wood{
	use PillarRotationInMetadataTrait;

	protected function getAxisMetaShift() : int{
		return $this->isStripped() ? 0 : 2;
	}
}
