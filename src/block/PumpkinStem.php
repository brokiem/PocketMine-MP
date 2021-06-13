<?php

declare(strict_types=1);

namespace pocketmine\block;

class PumpkinStem extends Stem{

	protected function getPlant() : Block{
		return VanillaBlocks::PUMPKIN();
	}
}
