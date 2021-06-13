<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\item\VanillaItems;
use function mt_rand;

class Beetroot extends Crops{

	public function getDropsForCompatibleTool(Item $item) : array{
		if($this->age >= 7){
			return [
				VanillaItems::BEETROOT(),
				VanillaItems::BEETROOT_SEEDS()->setCount(mt_rand(0, 3))
			];
		}

		return [
			VanillaItems::BEETROOT_SEEDS()
		];
	}

	public function getPickedItem(bool $addUserData = false) : Item{
		return VanillaItems::BEETROOT_SEEDS();
	}
}
