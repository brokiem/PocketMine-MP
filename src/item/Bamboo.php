<?php

declare(strict_types=1);

namespace pocketmine\item;

use pocketmine\block\Block;
use pocketmine\block\VanillaBlocks;

final class Bamboo extends Item{

	public function getFuelTime() : int{
		return 50;
	}

	public function getBlock(?int $clickedFace = null) : Block{
		return VanillaBlocks::BAMBOO_SAPLING();
	}
}
