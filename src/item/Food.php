<?php

declare(strict_types=1);

namespace pocketmine\item;

use pocketmine\entity\Living;

abstract class Food extends Item implements FoodSourceItem{
	public function requiresHunger() : bool{
		return true;
	}

	public function getResidue() : Item{
		return ItemFactory::air();
	}

	public function getAdditionalEffects() : array{
		return [];
	}

	public function onConsume(Living $consumer) : void{

	}
}
