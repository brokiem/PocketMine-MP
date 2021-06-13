<?php

declare(strict_types=1);

namespace pocketmine\entity\effect;

abstract class InstantEffect extends Effect{

	public function getDefaultDuration() : int{
		return 1;
	}

	public function canTick(EffectInstance $instance) : bool{
		return true; //If forced to last longer than 1 tick, these apply every tick.
	}
}
