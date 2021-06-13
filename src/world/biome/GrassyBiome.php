<?php

declare(strict_types=1);

namespace pocketmine\world\biome;

use pocketmine\block\VanillaBlocks;

abstract class GrassyBiome extends Biome{

	public function __construct(){
		$this->setGroundCover([
			VanillaBlocks::GRASS(),
			VanillaBlocks::DIRT(),
			VanillaBlocks::DIRT(),
			VanillaBlocks::DIRT(),
			VanillaBlocks::DIRT()
		]);
	}
}
