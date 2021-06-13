<?php

declare(strict_types=1);

namespace pocketmine\entity\effect;

use pocketmine\entity\Entity;
use pocketmine\entity\Living;
use pocketmine\event\entity\EntityDamageByChildEntityEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;

class InstantDamageEffect extends InstantEffect{

	public function applyEffect(Living $entity, EffectInstance $instance, float $potency = 1.0, ?Entity $source = null) : void{
		//TODO: add particles (witch spell)
		$damage = (4 << $instance->getAmplifier()) * $potency;
		if($source !== null){
			$sourceOwner = $source->getOwningEntity();
			if($sourceOwner !== null){
				$ev = new EntityDamageByChildEntityEvent($sourceOwner, $source, $entity, EntityDamageEvent::CAUSE_MAGIC, $damage);
			}else{
				$ev = new EntityDamageByEntityEvent($source, $entity, EntityDamageEvent::CAUSE_MAGIC, $damage);
			}
		}else{
			$ev = new EntityDamageEvent($entity, EntityDamageEvent::CAUSE_MAGIC, $damage);
		}
		$entity->attack($ev);
	}
}
