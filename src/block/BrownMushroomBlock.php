<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\item\Item;
use function mt_rand;

class BrownMushroomBlock extends RedMushroomBlock{

	public function getDropsForCompatibleTool(Item $item) : array{
		return [
			VanillaBlocks::BROWN_MUSHROOM()->asItem()->setCount(mt_rand(0, 2))
		];
	}

	public function isAffectedBySilkTouch() : bool{
		return true;
	}
}
