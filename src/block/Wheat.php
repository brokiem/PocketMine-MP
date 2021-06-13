<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\item\VanillaItems;
use function mt_rand;

class Wheat extends Crops{

	public function getDropsForCompatibleTool(Item $item) : array{
		if($this->age >= 7){
			return [
				VanillaItems::WHEAT(),
				VanillaItems::WHEAT_SEEDS()->setCount(mt_rand(0, 3))
			];
		}else{
			return [
				VanillaItems::WHEAT_SEEDS()
			];
		}
	}

	public function getPickedItem(bool $addUserData = false) : Item{
		return VanillaItems::WHEAT_SEEDS();
	}
}
