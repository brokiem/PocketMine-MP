<?php

declare(strict_types=1);

namespace pocketmine\item;

use pocketmine\entity\effect\EffectInstance;
use pocketmine\entity\effect\VanillaEffects;

class SpiderEye extends Food{

	public function getFoodRestore() : int{
		return 2;
	}

	public function getSaturationRestore() : float{
		return 3.2;
	}

	public function getAdditionalEffects() : array{
		return [new EffectInstance(VanillaEffects::POISON(), 80)];
	}
}
