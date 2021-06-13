<?php

declare(strict_types=1);

namespace pocketmine\item;

use pocketmine\entity\effect\EffectInstance;
use pocketmine\entity\effect\VanillaEffects;

class GoldenApple extends Food{

	public function requiresHunger() : bool{
		return false;
	}

	public function getFoodRestore() : int{
		return 4;
	}

	public function getSaturationRestore() : float{
		return 9.6;
	}

	public function getAdditionalEffects() : array{
		return [
			new EffectInstance(VanillaEffects::REGENERATION(), 100, 1),
			new EffectInstance(VanillaEffects::ABSORPTION(), 2400)
		];
	}
}
