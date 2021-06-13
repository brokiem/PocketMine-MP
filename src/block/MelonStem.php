<?php

declare(strict_types=1);

namespace pocketmine\block;

class MelonStem extends Stem{

	protected function getPlant() : Block{
		return VanillaBlocks::MELON();
	}
}
