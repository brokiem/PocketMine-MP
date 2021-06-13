<?php

declare(strict_types=1);

namespace pocketmine\entity\effect;

use pocketmine\entity\Living;

class SpeedEffect extends Effect{

	public function add(Living $entity, EffectInstance $instance) : void{
		$entity->setMovementSpeed($entity->getMovementSpeed() * (1 + 0.2 * $instance->getEffectLevel()));
	}

	public function remove(Living $entity, EffectInstance $instance) : void{
		$entity->setMovementSpeed($entity->getMovementSpeed() / (1 + 0.2 * $instance->getEffectLevel()));
	}
}
