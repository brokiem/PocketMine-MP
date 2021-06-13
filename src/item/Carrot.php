<?php

declare(strict_types=1);

namespace pocketmine\item;

use pocketmine\block\Block;
use pocketmine\block\VanillaBlocks;

class Carrot extends Food{

	public function getBlock(?int $clickedFace = null) : Block{
		return VanillaBlocks::CARROTS();
	}

	public function getFoodRestore() : int{
		return 3;
	}

	public function getSaturationRestore() : float{
		return 4.8;
	}
}
