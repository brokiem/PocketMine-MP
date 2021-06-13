<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\block\utils\Fallable;
use pocketmine\block\utils\FallableTrait;
use pocketmine\item\Item;
use pocketmine\item\VanillaItems;
use function mt_rand;

class Gravel extends Opaque implements Fallable{
	use FallableTrait;

	public function getDropsForCompatibleTool(Item $item) : array{
		if(mt_rand(1, 10) === 1){
			return [
				VanillaItems::FLINT()
			];
		}

		return parent::getDropsForCompatibleTool($item);
	}

	public function isAffectedBySilkTouch() : bool{
		return true;
	}

	public function tickFalling() : ?Block{
		return null;
	}
}
