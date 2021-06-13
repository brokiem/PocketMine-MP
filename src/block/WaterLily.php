<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\math\AxisAlignedBB;
use pocketmine\math\Facing;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\world\BlockTransaction;

class WaterLily extends Flowable{

	/**
	 * @return AxisAlignedBB[]
	 */
	protected function recalculateCollisionBoxes() : array{
		return [AxisAlignedBB::one()->contract(1 / 16, 0, 1 / 16)->trim(Facing::UP, 63 / 64)];
	}

	public function place(BlockTransaction $tx, Item $item, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector, ?Player $player = null) : bool{
		if($blockClicked instanceof Water){
			$up = $blockClicked->getSide(Facing::UP);
			if($up->canBeReplaced()){
				return parent::place($tx, $item, $up, $blockClicked, $face, $clickVector, $player);
			}
		}

		return false;
	}

	public function onNearbyBlockChange() : void{
		if(!($this->getSide(Facing::DOWN) instanceof Water)){
			$this->pos->getWorld()->useBreakOn($this->pos);
		}
	}
}
