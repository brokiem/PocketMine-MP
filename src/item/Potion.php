<?php

declare(strict_types=1);

namespace pocketmine\item;

use pocketmine\entity\Living;

class Potion extends Item implements ConsumableItem{

	private PotionType $potionType;

	public function __construct(ItemIdentifier $identifier, string $name, PotionType $potionType){
		parent::__construct($identifier, $name);
		$this->potionType = $potionType;
	}

	public function getMaxStackSize() : int{
		return 1;
	}

	public function onConsume(Living $consumer) : void{

	}

	public function getAdditionalEffects() : array{
		//TODO: check CustomPotionEffects NBT
		return $this->potionType->getEffects();
	}

	public function getResidue() : Item{
		return VanillaItems::GLASS_BOTTLE();
	}
}
