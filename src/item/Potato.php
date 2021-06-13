<?php

declare(strict_types=1);

namespace pocketmine\item;

use pocketmine\block\Block;
use pocketmine\block\VanillaBlocks;

class Potato extends Food{

	public function getBlock(?int $clickedFace = null) : Block{
		return VanillaBlocks::POTATOES();
	}

	public function getFoodRestore() : int{
		return 1;
	}

	public function getSaturationRestore() : float{
		return 0.6;
	}
}
