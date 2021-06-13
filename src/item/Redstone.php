<?php

declare(strict_types=1);

namespace pocketmine\item;

use pocketmine\block\Block;
use pocketmine\block\VanillaBlocks;

class Redstone extends Item{

	public function getBlock(?int $clickedFace = null) : Block{
		return VanillaBlocks::REDSTONE_WIRE();
	}
}
