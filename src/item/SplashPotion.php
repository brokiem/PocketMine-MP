<?php

declare(strict_types=1);

namespace pocketmine\item;

use pocketmine\entity\Location;
use pocketmine\entity\projectile\SplashPotion as SplashPotionEntity;
use pocketmine\entity\projectile\Throwable;
use pocketmine\player\Player;

class SplashPotion extends ProjectileItem{

	private PotionType $potionType;

	public function __construct(ItemIdentifier $identifier, string $name, PotionType $potionType){
		parent::__construct($identifier, $name);
		$this->potionType = $potionType;
	}

	public function getMaxStackSize() : int{
		return 1;
	}

	protected function createEntity(Location $location, Player $thrower) : Throwable{
		return new SplashPotionEntity($location, $thrower, $this->potionType);
	}

	public function getThrowForce() : float{
		return 0.5;
	}
}
