<?php

declare(strict_types=1);

namespace pocketmine\entity\effect;

use pocketmine\entity\Entity;
use pocketmine\entity\Living;
use pocketmine\event\entity\EntityRegainHealthEvent;

class RegenerationEffect extends Effect{

	public function canTick(EffectInstance $instance) : bool{
		if(($interval = (40 >> $instance->getAmplifier())) > 0){
			return ($instance->getDuration() % $interval) === 0;
		}
		return true;
	}

	public function applyEffect(Living $entity, EffectInstance $instance, float $potency = 1.0, ?Entity $source = null) : void{
		if($entity->getHealth() < $entity->getMaxHealth()){
			$ev = new EntityRegainHealthEvent($entity, 1, EntityRegainHealthEvent::CAUSE_MAGIC);
			$entity->heal($ev);
		}
	}
}
