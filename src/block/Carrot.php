<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\item\VanillaItems;
use function mt_rand;

class Carrot extends Crops{

	public function getDropsForCompatibleTool(Item $item) : array{
		return [
			VanillaItems::CARROT()->setCount($this->age >= 7 ? mt_rand(1, 4) : 1)
		];
	}

	public function getPickedItem(bool $addUserData = false) : Item{
		return VanillaItems::CARROT();
	}
}
