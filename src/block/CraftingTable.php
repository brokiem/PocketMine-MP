<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\crafting\CraftingGrid;
use pocketmine\item\Item;
use pocketmine\math\Vector3;
use pocketmine\player\Player;

class CraftingTable extends Opaque{

	public function onInteract(Item $item, int $face, Vector3 $clickVector, ?Player $player = null) : bool{
		if($player instanceof Player){
			$player->setCraftingGrid(new CraftingGrid($player, CraftingGrid::SIZE_BIG));
		}

		return true;
	}

	public function getFuelTime() : int{
		return 300;
	}
}
