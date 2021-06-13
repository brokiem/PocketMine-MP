<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\block\utils\BlockDataSerializer;
use pocketmine\item\Item;
use pocketmine\math\AxisAlignedBB;
use pocketmine\math\Facing;

class Farmland extends Transparent{

	protected int $wetness = 0; //"moisture" blockstate property in PC

	protected function writeStateToMeta() : int{
		return $this->wetness;
	}

	public function readStateFromData(int $id, int $stateMeta) : void{
		$this->wetness = BlockDataSerializer::readBoundedInt("wetness", $stateMeta, 0, 7);
	}

	public function getStateBitmask() : int{
		return 0b111;
	}

	public function getWetness() : int{ return $this->wetness; }

	/** @return $this */
	public function setWetness(int $wetness) : self{
		if($wetness < 0 || $wetness > 7){
			throw new \InvalidArgumentException("Wetness must be in range 0-7");
		}
		$this->wetness = $wetness;
		return $this;
	}

	/**
	 * @return AxisAlignedBB[]
	 */
	protected function recalculateCollisionBoxes() : array{
		return [AxisAlignedBB::one()]; //TODO: this should be trimmed at the top by 1/16, but MCPE currently treats them as a full block (https://bugs.mojang.com/browse/MCPE-12109)
	}

	public function onNearbyBlockChange() : void{
		if($this->getSide(Facing::UP)->isSolid()){
			$this->pos->getWorld()->setBlock($this->pos, VanillaBlocks::DIRT());
		}
	}

	public function ticksRandomly() : bool{
		return true;
	}

	public function onRandomTick() : void{
		if(!$this->canHydrate()){
			if($this->wetness > 0){
				$this->wetness--;
				$this->pos->getWorld()->setBlock($this->pos, $this, false);
			}else{
				$this->pos->getWorld()->setBlock($this->pos, VanillaBlocks::DIRT());
			}
		}elseif($this->wetness < 7){
			$this->wetness = 7;
			$this->pos->getWorld()->setBlock($this->pos, $this, false);
		}
	}

	protected function canHydrate() : bool{
		//TODO: check rain
		$start = $this->pos->add(-4, 0, -4);
		$end = $this->pos->add(4, 1, 4);
		for($y = $start->y; $y <= $end->y; ++$y){
			for($z = $start->z; $z <= $end->z; ++$z){
				for($x = $start->x; $x <= $end->x; ++$x){
					if($this->pos->getWorld()->getBlockAt($x, $y, $z) instanceof Water){
						return true;
					}
				}
			}
		}

		return false;
	}

	public function getDropsForCompatibleTool(Item $item) : array{
		return [
			VanillaBlocks::DIRT()->asItem()
		];
	}

	public function getPickedItem(bool $addUserData = false) : Item{
		return VanillaBlocks::DIRT()->asItem();
	}
}
