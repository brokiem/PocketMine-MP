<?php

declare(strict_types=1);

namespace pocketmine\item;

use pocketmine\entity\effect\EffectInstance;
use pocketmine\entity\effect\VanillaEffects;
use function lcg_value;

class RottenFlesh extends Food{

	public function getFoodRestore() : int{
		return 4;
	}

	public function getSaturationRestore() : float{
		return 0.8;
	}

	public function getAdditionalEffects() : array{
		if(lcg_value() <= 0.8){
			return [
				new EffectInstance(VanillaEffects::HUNGER(), 600)
			];
		}

		return [];
	}
}
