<?php

declare(strict_types=1);

namespace pocketmine\entity\effect;

use pocketmine\entity\Entity;
use pocketmine\entity\Living;
use pocketmine\event\entity\EntityRegainHealthEvent;

class InstantHealthEffect extends InstantEffect{

	public function applyEffect(Living $entity, EffectInstance $instance, float $potency = 1.0, ?Entity $source = null) : void{
		if($entity->getHealth() < $entity->getMaxHealth()){
			$entity->heal(new EntityRegainHealthEvent($entity, (4 << $instance->getAmplifier()) * $potency, EntityRegainHealthEvent::CAUSE_MAGIC));
		}
	}

}
