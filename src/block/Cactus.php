<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\block\utils\BlockDataSerializer;
use pocketmine\entity\Entity;
use pocketmine\event\block\BlockGrowEvent;
use pocketmine\event\entity\EntityDamageByBlockEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\item\Item;
use pocketmine\math\AxisAlignedBB;
use pocketmine\math\Facing;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\world\BlockTransaction;

class Cactus extends Transparent{

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

	public function getAge() : int{ return $this->age; }

	/** @return $this */
	public function setAge(int $age) : self{
		if($age < 0 || $age > 15){
			throw new \InvalidArgumentException("Age must be in range 0-15");
		}
		$this->age = $age;
		return $this;
	}

	public function hasEntityCollision() : bool{
		return true;
	}

	/**
	 * @return AxisAlignedBB[]
	 */
	protected function recalculateCollisionBoxes() : array{
		static $shrinkSize = 1 / 16;
		return [AxisAlignedBB::one()->contract($shrinkSize, 0, $shrinkSize)->trim(Facing::UP, $shrinkSize)];
	}

	public function onEntityInside(Entity $entity) : bool{
		$ev = new EntityDamageByBlockEvent($this, $entity, EntityDamageEvent::CAUSE_CONTACT, 1);
		$entity->attack($ev);
		return true;
	}

	public function onNearbyBlockChange() : void{
		$down = $this->getSide(Facing::DOWN);
		if($down->getId() !== BlockLegacyIds::SAND and !$down->isSameType($this)){
			$this->pos->getWorld()->useBreakOn($this->pos);
		}else{
			foreach(Facing::HORIZONTAL as $side){
				$b = $this->getSide($side);
				if($b->isSolid()){
					$this->pos->getWorld()->useBreakOn($this->pos);
					break;
				}
			}
		}
	}

	public function ticksRandomly() : bool{
		return true;
	}

	public function onRandomTick() : void{
		if(!$this->getSide(Facing::DOWN)->isSameType($this)){
			if($this->age === 15){
				for($y = 1; $y < 3; ++$y){
					if(!$this->pos->getWorld()->isInWorld($this->pos->x, $this->pos->y + $y, $this->pos->z)){
						break;
					}
					$b = $this->pos->getWorld()->getBlockAt($this->pos->x, $this->pos->y + $y, $this->pos->z);
					if($b->getId() === BlockLegacyIds::AIR){
						$ev = new BlockGrowEvent($b, VanillaBlocks::CACTUS());
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
			}else{
				++$this->age;
				$this->pos->getWorld()->setBlock($this->pos, $this);
			}
		}
	}

	public function place(BlockTransaction $tx, Item $item, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector, ?Player $player = null) : bool{
		$down = $this->getSide(Facing::DOWN);
		if($down->getId() === BlockLegacyIds::SAND or $down->isSameType($this)){
			foreach(Facing::HORIZONTAL as $side){
				if($this->getSide($side)->isSolid()){
					return false;
				}
			}

			return parent::place($tx, $item, $blockReplace, $blockClicked, $face, $clickVector, $player);
		}

		return false;
	}
}
