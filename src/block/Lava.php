<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\entity\Entity;
use pocketmine\event\entity\EntityCombustByBlockEvent;
use pocketmine\event\entity\EntityDamageByBlockEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\math\Facing;
use pocketmine\world\sound\BucketEmptyLavaSound;
use pocketmine\world\sound\BucketFillLavaSound;
use pocketmine\world\sound\Sound;

class Lava extends Liquid{

	public function getLightLevel() : int{
		return 15;
	}

	public function getBucketFillSound() : Sound{
		return new BucketFillLavaSound();
	}

	public function getBucketEmptySound() : Sound{
		return new BucketEmptyLavaSound();
	}

	public function tickRate() : int{
		return 30;
	}

	public function getFlowDecayPerBlock() : int{
		return 2; //TODO: this is 1 in the nether
	}

	protected function checkForHarden() : bool{
		if($this->falling){
			return false;
		}
		$colliding = null;
		foreach(Facing::ALL as $side){
			if($side === Facing::DOWN){
				continue;
			}
			$blockSide = $this->getSide($side);
			if($blockSide instanceof Water){
				$colliding = $blockSide;
				break;
			}
		}

		if($colliding !== null){
			if($this->decay === 0){
				$this->liquidCollide($colliding, VanillaBlocks::OBSIDIAN());
				return true;
			}elseif($this->decay <= 4){
				$this->liquidCollide($colliding, VanillaBlocks::COBBLESTONE());
				return true;
			}
		}
		return false;
	}

	protected function flowIntoBlock(Block $block, int $newFlowDecay, bool $falling) : void{
		if($block instanceof Water){
			$block->liquidCollide($this, VanillaBlocks::STONE());
		}else{
			parent::flowIntoBlock($block, $newFlowDecay, $falling);
		}
	}

	public function onEntityInside(Entity $entity) : bool{
		$entity->fallDistance *= 0.5;

		$ev = new EntityDamageByBlockEvent($this, $entity, EntityDamageEvent::CAUSE_LAVA, 4);
		$entity->attack($ev);

		$ev = new EntityCombustByBlockEvent($this, $entity, 15);
		$ev->call();
		if(!$ev->isCancelled()){
			$entity->setOnFire($ev->getDuration());
		}

		$entity->resetFallDistance();
		return true;
	}
}
