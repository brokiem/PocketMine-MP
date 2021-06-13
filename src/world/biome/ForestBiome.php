<?php

declare(strict_types=1);

namespace pocketmine\world\biome;

use pocketmine\block\utils\TreeType;
use pocketmine\world\generator\populator\TallGrass;
use pocketmine\world\generator\populator\Tree;

class ForestBiome extends GrassyBiome{

	/** @var TreeType */
	private $type;

	public function __construct(?TreeType $type = null){
		parent::__construct();

		$this->type = $type ?? TreeType::OAK();

		$trees = new Tree($type);
		$trees->setBaseAmount(5);
		$this->addPopulator($trees);

		$tallGrass = new TallGrass();
		$tallGrass->setBaseAmount(3);

		$this->addPopulator($tallGrass);

		$this->setElevation(63, 81);

		if($this->type->equals(TreeType::BIRCH())){
			$this->temperature = 0.6;
			$this->rainfall = 0.5;
		}else{
			$this->temperature = 0.7;
			$this->rainfall = 0.8;
		}
	}

	public function getName() : string{
		return $this->type->getDisplayName() . " Forest";
	}
}
