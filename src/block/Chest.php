<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\block\tile\Chest as TileChest;
use pocketmine\block\utils\FacesOppositePlacingPlayerTrait;
use pocketmine\block\utils\NormalHorizontalFacingInMetadataTrait;
use pocketmine\item\Item;
use pocketmine\math\AxisAlignedBB;
use pocketmine\math\Facing;
use pocketmine\math\Vector3;
use pocketmine\player\Player;

class Chest extends Transparent{
	use FacesOppositePlacingPlayerTrait;
	use NormalHorizontalFacingInMetadataTrait;

	/**
	 * @return AxisAlignedBB[]
	 */
	protected function recalculateCollisionBoxes() : array{
		//these are slightly bigger than in PC
		return [AxisAlignedBB::one()->contract(0.025, 0, 0.025)->trim(Facing::UP, 0.05)];
	}

	public function onPostPlace() : void{
		$tile = $this->pos->getWorld()->getTile($this->pos);
		if($tile instanceof TileChest){
			foreach([
				Facing::rotateY($this->facing, true),
				Facing::rotateY($this->facing, false)
			] as $side){
				$c = $this->getSide($side);
				if($c instanceof Chest and $c->isSameType($this) and $c->facing === $this->facing){
					$pair = $this->pos->getWorld()->getTile($c->pos);
					if($pair instanceof TileChest and !$pair->isPaired()){
						$pair->pairWith($tile);
						$tile->pairWith($pair);
						break;
					}
				}
			}
		}
	}

	public function onInteract(Item $item, int $face, Vector3 $clickVector, ?Player $player = null) : bool{
		if($player instanceof Player){

			$chest = $this->pos->getWorld()->getTile($this->pos);
			if($chest instanceof TileChest){
				if(
					!$this->getSide(Facing::UP)->isTransparent() or
					(($pair = $chest->getPair()) !== null and !$pair->getBlock()->getSide(Facing::UP)->isTransparent()) or
					!$chest->canOpenWith($item->getCustomName())
				){
					return true;
				}

				$player->setCurrentWindow($chest->getInventory());
			}
		}

		return true;
	}

	public function getFuelTime() : int{
		return 300;
	}
}
