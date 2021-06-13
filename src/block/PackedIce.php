<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\item\Item;

class PackedIce extends Opaque{

	public function getFrictionFactor() : float{
		return 0.98;
	}

	public function getDropsForCompatibleTool(Item $item) : array{
		return [];
	}

	public function isAffectedBySilkTouch() : bool{
		return true;
	}
}
