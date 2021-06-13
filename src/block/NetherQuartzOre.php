<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\item\VanillaItems;
use function mt_rand;

class NetherQuartzOre extends Opaque{

	public function getDropsForCompatibleTool(Item $item) : array{
		return [
			VanillaItems::NETHER_QUARTZ()
		];
	}

	public function isAffectedBySilkTouch() : bool{
		return true;
	}

	protected function getXpDropAmount() : int{
		return mt_rand(2, 5);
	}
}
