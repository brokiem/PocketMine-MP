<?php

declare(strict_types=1);

namespace pocketmine\world\biome;

use pocketmine\block\utils\TreeType;
use pocketmine\world\generator\populator\TallGrass;
use pocketmine\world\generator\populator\Tree;

class TaigaBiome extends SnowyBiome{

	public function __construct(){
		parent::__construct();

		$trees = new Tree(TreeType::SPRUCE());
		$trees->setBaseAmount(10);
		$this->addPopulator($trees);

		$tallGrass = new TallGrass();
		$tallGrass->setBaseAmount(1);

		$this->addPopulator($tallGrass);

		$this->setElevation(63, 81);

		$this->temperature = 0.05;
		$this->rainfall = 0.8;
	}

	public function getName() : string{
		return "Taiga";
	}
}
