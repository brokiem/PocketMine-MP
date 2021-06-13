<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\item\Item;

class BlueIce extends Opaque{

	public function getLightLevel() : int{
		return 1;
	}

	public function getFrictionFactor() : float{
		return 0.99;
	}

	public function getDropsForCompatibleTool(Item $item) : array{
		return [];
	}
}
