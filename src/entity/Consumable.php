<?php

declare(strict_types=1);

namespace pocketmine\entity;

use pocketmine\entity\effect\EffectInstance;

/**
 * Interface implemented by objects that can be consumed by mobs.
 */
interface Consumable{
	/**
	 * @return EffectInstance[]
	 */
	public function getAdditionalEffects() : array;

	/**
	 * Called when this Consumable is consumed by mob, after standard resulting effects have been applied.
	 */
	public function onConsume(Living $consumer) : void;
}
