<?php

declare(strict_types=1);

namespace pocketmine\entity\effect;

use pocketmine\entity\Living;

class HealthBoostEffect extends Effect{

	public function add(Living $entity, EffectInstance $instance) : void{
		$entity->setMaxHealth($entity->getMaxHealth() + 4 * $instance->getEffectLevel());
	}

	public function remove(Living $entity, EffectInstance $instance) : void{
		$entity->setMaxHealth($entity->getMaxHealth() - 4 * $instance->getEffectLevel());
	}
}
