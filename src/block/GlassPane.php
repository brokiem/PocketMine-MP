<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\item\Item;

class GlassPane extends Thin{

	public function getDropsForCompatibleTool(Item $item) : array{
		return [];
	}

	public function isAffectedBySilkTouch() : bool{
		return true;
	}
}
