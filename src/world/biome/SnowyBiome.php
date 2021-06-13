<?php

declare(strict_types=1);

namespace pocketmine\world\biome;

use pocketmine\block\VanillaBlocks;

abstract class SnowyBiome extends Biome{

	public function __construct(){
		$this->setGroundCover([
			VanillaBlocks::SNOW_LAYER(),
			VanillaBlocks::GRASS(),
			VanillaBlocks::DIRT(),
			VanillaBlocks::DIRT(),
			VanillaBlocks::DIRT()
		]);
	}
}
