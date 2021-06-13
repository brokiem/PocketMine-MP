<?php

declare(strict_types=1);

namespace pocketmine\entity\effect;

use pocketmine\entity\Living;

class InvisibilityEffect extends Effect{

	public function add(Living $entity, EffectInstance $instance) : void{
		$entity->setInvisible();
		$entity->setNameTagVisible(false);
	}

	public function remove(Living $entity, EffectInstance $instance) : void{
		$entity->setInvisible(false);
		$entity->setNameTagVisible();
	}
}
