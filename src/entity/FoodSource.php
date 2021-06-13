<?php

declare(strict_types=1);

namespace pocketmine\entity;

/**
 * Interface implemented by objects that can be consumed by players, giving them food and saturation.
 */
interface FoodSource extends Consumable{

	public function getFoodRestore() : int;

	public function getSaturationRestore() : float;

	/**
	 * Returns whether a Human eating this FoodSource must have a non-full hunger bar.
	 */
	public function requiresHunger() : bool;
}
