<?php

declare(strict_types=1);

namespace pocketmine\item\enchantment;

use pocketmine\entity\Entity;

class SharpnessEnchantment extends MeleeWeaponEnchantment{

	public function isApplicableTo(Entity $victim) : bool{
		return true;
	}

	public function getDamageBonus(int $enchantmentLevel) : float{
		return 0.5 * ($enchantmentLevel + 1);
	}
}
