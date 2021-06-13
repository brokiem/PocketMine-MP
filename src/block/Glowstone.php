<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\item\VanillaItems;
use function mt_rand;

class Glowstone extends Transparent{

	public function getLightLevel() : int{
		return 15;
	}

	public function getDropsForCompatibleTool(Item $item) : array{
		return [
			VanillaItems::GLOWSTONE_DUST()->setCount(mt_rand(2, 4))
		];
	}

	public function isAffectedBySilkTouch() : bool{
		return true;
	}
}
