<?php

declare(strict_types=1);

namespace pocketmine\world\generator\object;

use pocketmine\block\VanillaBlocks;
use pocketmine\utils\Random;
use pocketmine\world\ChunkManager;

class OakTree extends Tree{

	public function __construct(){
		parent::__construct(VanillaBlocks::OAK_LOG(), VanillaBlocks::OAK_LEAVES());
	}

	public function placeObject(ChunkManager $world, int $x, int $y, int $z, Random $random) : void{
		$this->treeHeight = $random->nextBoundedInt(3) + 4;
		parent::placeObject($world, $x, $y, $z, $random);
	}
}
