<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\block\utils\ColorInMetadataTrait;
use pocketmine\block\utils\DyeColor;

class Concrete extends Opaque{
	use ColorInMetadataTrait;

	public function __construct(BlockIdentifier $idInfo, string $name, BlockBreakInfo $breakInfo){
		$this->color = DyeColor::WHITE();
		parent::__construct($idInfo, $name, $breakInfo);
	}
}
