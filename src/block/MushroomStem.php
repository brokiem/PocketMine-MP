<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\item\Item;

final class MushroomStem extends Opaque{

	public function getDropsForCompatibleTool(Item $item) : array{ return []; }

	public function isAffectedBySilkTouch() : bool{ return true; }
}
