<?php

declare(strict_types=1);

namespace pocketmine\entity\effect;

use pocketmine\entity\Entity;
use pocketmine\entity\Living;
use pocketmine\player\Player;

class LevitationEffect extends Effect{

	public function canTick(EffectInstance $instance) : bool{
		return true;
	}

	public function applyEffect(Living $entity, EffectInstance $instance, float $potency = 1.0, ?Entity $source = null) : void{
		if(!($entity instanceof Player)){ //TODO: ugly hack, player motion isn't updated properly by the server yet :(
			$entity->addMotion(0, ($instance->getEffectLevel() / 20 - $entity->getMotion()->y) / 5, 0);
		}
	}

	public function add(Living $entity, EffectInstance $instance) : void{
		$entity->setHasGravity(false);
	}

	public function remove(Living $entity, EffectInstance $instance) : void{
		$entity->setHasGravity();
	}
}
