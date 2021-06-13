<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\item\VanillaItems;

class Clay extends Opaque{

	public function getDropsForCompatibleTool(Item $item) : array{
		return [
			VanillaItems::CLAY()->setCount(4)
		];
	}

	public function isAffectedBySilkTouch() : bool{
		return true;
	}
}
