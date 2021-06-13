<?php

declare(strict_types=1);

namespace pocketmine\world\biome;

class SmallMountainsBiome extends MountainsBiome{

	public function __construct(){
		parent::__construct();

		$this->setElevation(63, 97);
	}

	public function getName() : string{
		return "Small Mountains";
	}
}
