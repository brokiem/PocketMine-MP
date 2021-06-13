<?php

declare(strict_types=1);

namespace pocketmine\item\enchantment;

use pocketmine\entity\Entity;

class FireAspectEnchantment extends MeleeWeaponEnchantment{

	public function isApplicableTo(Entity $victim) : bool{
		return true;
	}

	public function getDamageBonus(int $enchantmentLevel) : float{
		return 0;
	}

	public function onPostAttack(Entity $attacker, Entity $victim, int $enchantmentLevel) : void{
		$victim->setOnFire($enchantmentLevel * 4);
	}
}
