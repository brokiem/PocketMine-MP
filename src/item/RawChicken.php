<?php

declare(strict_types=1);

namespace pocketmine\item;

use pocketmine\entity\effect\EffectInstance;
use pocketmine\entity\effect\VanillaEffects;
use function mt_rand;

class RawChicken extends Food{

	public function getFoodRestore() : int{
		return 2;
	}

	public function getSaturationRestore() : float{
		return 1.2;
	}

	public function getAdditionalEffects() : array{
		return mt_rand(0, 9) < 3 ? [new EffectInstance(VanillaEffects::HUNGER(), 600)] : [];
	}
}
