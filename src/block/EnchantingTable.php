<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\block\inventory\EnchantInventory;
use pocketmine\item\Item;
use pocketmine\math\AxisAlignedBB;
use pocketmine\math\Facing;
use pocketmine\math\Vector3;
use pocketmine\player\Player;

class EnchantingTable extends Transparent{

	/**
	 * @return AxisAlignedBB[]
	 */
	protected function recalculateCollisionBoxes() : array{
		return [AxisAlignedBB::one()->trim(Facing::UP, 0.25)];
	}

	public function onInteract(Item $item, int $face, Vector3 $clickVector, ?Player $player = null) : bool{
		if($player instanceof Player){
			//TODO lock

			$player->setCurrentWindow(new EnchantInventory($this->pos));
		}

		return true;
	}
}
