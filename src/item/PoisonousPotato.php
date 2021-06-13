<?php

declare(strict_types=1);

namespace pocketmine\item;

use pocketmine\entity\effect\EffectInstance;
use pocketmine\entity\effect\VanillaEffects;
use function mt_rand;

class PoisonousPotato extends Food{

	public function getFoodRestore() : int{
		return 2;
	}

	public function getSaturationRestore() : float{
		return 1.2;
	}

	public function getAdditionalEffects() : array{
		if(mt_rand(0, 100) > 40){
			return [
				new EffectInstance(VanillaEffects::POISON(), 100)
			];
		}
		return [];
	}
}
