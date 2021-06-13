<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\block\utils\BlockDataSerializer;
use pocketmine\event\block\BlockGrowEvent;
use pocketmine\item\Fertilizer;
use pocketmine\item\Item;
use pocketmine\math\Facing;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\world\BlockTransaction;

class Sugarcane extends Flowable{

	protected int $age = 0;

	protected function writeStateToMeta() : int{
		return $this->age;
	}

	public function readStateFromData(int $id, int $stateMeta) : void{
		$this->age = BlockDataSerializer::readBoundedInt("age", $stateMeta, 0, 15);
	}

	public function getStateBitmask() : int{
		return 0b1111;
	}

	private function grow() : void{
		for($y = 1; $y < 3; ++$y){
			if(!$this->pos->getWorld()->isInWorld($this->pos->x, $this->pos->y + $y, $this->pos->z)){
				break;
			}
			$b = $this->pos->getWorld()->getBlockAt($this->pos->x, $this->pos->y + $y, $this->pos->z);
			if($b->getId() === BlockLegacyIds::AIR){
				$ev = new BlockGrowEvent($b, VanillaBlocks::SUGARCANE());
				$ev->call();
				if($ev->isCancelled()){
					break;
				}
				$this->pos->getWorld()->setBlock($b->pos, $ev->getNewState());
			}else{
				break;
			}
		}
		$this->age = 0;
		$this->pos->getWorld()->setBlock($this->pos, $this);
	}

	public function getAge() : int{ return $this->age; }

	/** @return $this */
	public function setAge(int $age) : self{
		if($age < 0 || $age > 15){
			throw new \InvalidArgumentException("Age must be in range 0-15");
		}
		$this->age = $age;
		return $this;
	}

	public function onInteract(Item $item, int $face, Vector3 $clickVector, ?Player $player = null) : bool{
		if($item instanceof Fertilizer){
			if(!$this->getSide(Facing::DOWN)->isSameType($this)){
				$this->grow();
			}

			$item->pop();

			return true;
		}

		return false;
	}

	public function onNearbyBlockChange() : void{
		$down = $this->getSide(Facing::DOWN);
		if($down->isTransparent() and !$down->isSameType($this)){
			$this->pos->getWorld()->useBreakOn($this->pos);
		}
	}

	public function ticksRandomly() : bool{
		return true;
	}

	public function onRandomTick() : void{
		if(!$this->getSide(Facing::DOWN)->isSameType($this)){
			if($this->age === 15){
				$this->grow();
			}else{
				++$this->age;
				$this->pos->getWorld()->setBlock($this->pos, $this);
			}
		}
	}

	public function place(BlockTransaction $tx, Item $item, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector, ?Player $player = null) : bool{
		$down = $this->getSide(Facing::DOWN);
		if($down->isSameType($this)){
			return parent::place($tx, $item, $blockReplace, $blockClicked, $face, $clickVector, $player);
		}elseif($down->getId() === BlockLegacyIds::GRASS or $down->getId() === BlockLegacyIds::DIRT or $down->getId() === BlockLegacyIds::SAND or $down->getId() === BlockLegacyIds::PODZOL){
			foreach(Facing::HORIZONTAL as $side){
				if($down->getSide($side) instanceof Water){
					return parent::place($tx, $item, $blockReplace, $blockClicked, $face, $clickVector, $player);
				}
			}
		}

		return false;
	}
}
