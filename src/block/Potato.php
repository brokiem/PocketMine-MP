<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\item\VanillaItems;
use function mt_rand;

class Potato extends Crops{

	public function getDropsForCompatibleTool(Item $item) : array{
		$result = [
			VanillaItems::POTATO()->setCount($this->age >= 7 ? mt_rand(1, 5) : 1)
		];
		if($this->age >= 7 && mt_rand(0, 49) === 0){
			$result[] = VanillaItems::POISONOUS_POTATO();
		}
		return $result;
	}

	public function getPickedItem(bool $addUserData = false) : Item{
		return VanillaItems::POTATO();
	}
}
