<?php

declare(strict_types=1);

namespace pocketmine\item;

use pocketmine\item\enchantment\VanillaEnchantments;

abstract class Tool extends Durable{

	public function getMaxStackSize() : int{
		return 1;
	}

	public function getMiningEfficiency(bool $isCorrectTool) : float{
		$efficiency = 1;
		if($isCorrectTool){
			$efficiency = $this->getBaseMiningEfficiency();
			if(($enchantmentLevel = $this->getEnchantmentLevel(VanillaEnchantments::EFFICIENCY())) > 0){
				$efficiency += ($enchantmentLevel ** 2 + 1);
			}
		}

		return $efficiency;
	}

	protected function getBaseMiningEfficiency() : float{
		return 1;
	}
}
