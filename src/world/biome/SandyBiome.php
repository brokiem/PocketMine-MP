<?php

declare(strict_types=1);

namespace pocketmine\world\biome;

use pocketmine\block\VanillaBlocks;

abstract class SandyBiome extends Biome{

	public function __construct(){
		$this->setGroundCover([
			VanillaBlocks::SAND(),
			VanillaBlocks::SAND(),
			VanillaBlocks::SANDSTONE(),
			VanillaBlocks::SANDSTONE(),
			VanillaBlocks::SANDSTONE()
		]);
	}
}
