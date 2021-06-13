<?php

declare(strict_types=1);

namespace pocketmine\entity\effect;

use pocketmine\entity\Entity;
use pocketmine\entity\Human;
use pocketmine\entity\Living;
use pocketmine\event\player\PlayerExhaustEvent;

class HungerEffect extends Effect{

	public function canTick(EffectInstance $instance) : bool{
		return true;
	}

	public function applyEffect(Living $entity, EffectInstance $instance, float $potency = 1.0, ?Entity $source = null) : void{
		if($entity instanceof Human){
			$entity->getHungerManager()->exhaust(0.025 * $instance->getEffectLevel(), PlayerExhaustEvent::CAUSE_POTION);
		}
	}
}
