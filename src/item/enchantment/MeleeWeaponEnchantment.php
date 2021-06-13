<?php

declare(strict_types=1);

namespace pocketmine\item\enchantment;

use pocketmine\entity\Entity;

/**
 * Classes extending this class can be applied to weapons and activate when used by a mob to attack another mob in melee
 * combat.
 */
abstract class MeleeWeaponEnchantment extends Enchantment{

	/**
	 * Returns whether this melee enchantment has an effect on the target entity. For example, Smite only applies to
	 * undead mobs.
	 */
	abstract public function isApplicableTo(Entity $victim) : bool;

	/**
	 * Returns the amount of additional damage caused by this enchantment to applicable targets.
	 */
	abstract public function getDamageBonus(int $enchantmentLevel) : float;

	/**
	 * Called after damaging the entity to apply any post damage effects to the target.
	 */
	public function onPostAttack(Entity $attacker, Entity $victim, int $enchantmentLevel) : void{

	}
}
