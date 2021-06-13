<?php

declare(strict_types=1);

namespace pocketmine\world\generator\object;

use pocketmine\block\VanillaBlocks;
use pocketmine\utils\Random;
use pocketmine\world\ChunkManager;

class BirchTree extends Tree{
	/** @var bool */
	protected $superBirch = false;

	public function __construct(bool $superBirch = false){
		parent::__construct(VanillaBlocks::BIRCH_LOG(), VanillaBlocks::BIRCH_LEAVES());
		$this->superBirch = $superBirch;
	}

	public function placeObject(ChunkManager $world, int $x, int $y, int $z, Random $random) : void{
		$this->treeHeight = $random->nextBoundedInt(3) + 5;
		if($this->superBirch){
			$this->treeHeight += 5;
		}
		parent::placeObject($world, $x, $y, $z, $random);
	}
}
