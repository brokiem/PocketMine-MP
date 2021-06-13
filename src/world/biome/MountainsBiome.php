<?php

declare(strict_types=1);

namespace pocketmine\world\biome;

use pocketmine\block\VanillaBlocks;
use pocketmine\world\generator\object\OreType;
use pocketmine\world\generator\populator\Ore;
use pocketmine\world\generator\populator\TallGrass;
use pocketmine\world\generator\populator\Tree;

class MountainsBiome extends GrassyBiome{

	public function __construct(){
		parent::__construct();

		$trees = new Tree();
		$trees->setBaseAmount(1);
		$this->addPopulator($trees);

		$tallGrass = new TallGrass();
		$tallGrass->setBaseAmount(1);

		$this->addPopulator($tallGrass);

		$ores = new Ore();
		$ores->setOreTypes([
			new OreType(VanillaBlocks::EMERALD_ORE(), VanillaBlocks::STONE(), 11, 1, 0, 32)
		]);

		$this->addPopulator($ores);

		$this->setElevation(63, 127);

		$this->temperature = 0.4;
		$this->rainfall = 0.5;
	}

	public function getName() : string{
		return "Mountains";
	}
}
