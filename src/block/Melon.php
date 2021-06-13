<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\item\VanillaItems;
use function mt_rand;

class Melon extends Transparent{

	public function getDropsForCompatibleTool(Item $item) : array{
		return [
			VanillaItems::MELON()->setCount(mt_rand(3, 7))
		];
	}

	public function isAffectedBySilkTouch() : bool{
		return true;
	}
}
