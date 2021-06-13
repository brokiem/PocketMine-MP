<?php

declare(strict_types=1);

namespace pocketmine\item;

use pocketmine\block\Block;
use pocketmine\block\BlockToolType;

class Shears extends Tool{

	public function getMaxDurability() : int{
		return 239;
	}

	public function getBlockToolType() : int{
		return BlockToolType::SHEARS;
	}

	public function getBlockToolHarvestLevel() : int{
		return 1;
	}

	protected function getBaseMiningEfficiency() : float{
		return 15;
	}

	public function onDestroyBlock(Block $block) : bool{
		return $this->applyDamage(1);
	}
}
