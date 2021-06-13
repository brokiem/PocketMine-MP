<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\item\VanillaItems;

class SeaLantern extends Transparent{

	public function getLightLevel() : int{
		return 15;
	}

	public function getDropsForCompatibleTool(Item $item) : array{
		return [
			VanillaItems::PRISMARINE_CRYSTALS()->setCount(3)
		];
	}

	public function isAffectedBySilkTouch() : bool{
		return true;
	}
}
