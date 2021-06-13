<?php

declare(strict_types=1);

namespace pocketmine\entity\effect;

use pocketmine\entity\Living;

class AbsorptionEffect extends Effect{

	public function add(Living $entity, EffectInstance $instance) : void{
		$new = (4 * $instance->getEffectLevel());
		if($new > $entity->getAbsorption()){
			$entity->setAbsorption($new);
		}
	}

	public function remove(Living $entity, EffectInstance $instance) : void{
		$entity->setAbsorption(0);
	}
}
