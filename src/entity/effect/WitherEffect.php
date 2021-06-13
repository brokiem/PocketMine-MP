<?php

declare(strict_types=1);

namespace pocketmine\entity\effect;

use pocketmine\entity\Entity;
use pocketmine\entity\Living;
use pocketmine\event\entity\EntityDamageEvent;

class WitherEffect extends Effect{

	public function canTick(EffectInstance $instance) : bool{
		if(($interval = (50 >> $instance->getAmplifier())) > 0){
			return ($instance->getDuration() % $interval) === 0;
		}
		return true;
	}

	public function applyEffect(Living $entity, EffectInstance $instance, float $potency = 1.0, ?Entity $source = null) : void{
		$ev = new EntityDamageEvent($entity, EntityDamageEvent::CAUSE_MAGIC, 1);
		$entity->attack($ev);
	}
}
