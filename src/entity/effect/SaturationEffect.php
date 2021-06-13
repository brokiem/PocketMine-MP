<?php

declare(strict_types=1);

namespace pocketmine\entity\effect;

use pocketmine\entity\Entity;
use pocketmine\entity\Human;
use pocketmine\entity\Living;

class SaturationEffect extends InstantEffect{

	public function applyEffect(Living $entity, EffectInstance $instance, float $potency = 1.0, ?Entity $source = null) : void{
		if($entity instanceof Human){
			$manager = $entity->getHungerManager();
			$manager->addFood($instance->getEffectLevel());
			$manager->addSaturation($instance->getEffectLevel() * 2);
		}
	}
}
