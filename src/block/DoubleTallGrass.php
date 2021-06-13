<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\item\VanillaItems;
use function mt_rand;

class DoubleTallGrass extends DoublePlant{

	public function canBeReplaced() : bool{
		return true;
	}

	public function getDrops(Item $item) : array{
		if($this->top and !$this->breakInfo->isToolCompatible($item) and mt_rand(0, 7) === 0){
			return [
				VanillaItems::WHEAT_SEEDS()
			];
		}
		return parent::getDrops($item);
	}
}
