<?php

declare(strict_types=1);

namespace pocketmine\world\generator\object;

use pocketmine\block\VanillaBlocks;

class JungleTree extends Tree{

	public function __construct(){
		parent::__construct(VanillaBlocks::JUNGLE_LOG(), VanillaBlocks::JUNGLE_LEAVES(), 8);
	}
}
