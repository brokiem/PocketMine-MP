<?php

declare(strict_types=1);

namespace pocketmine\item;

use pocketmine\entity\Location;
use pocketmine\entity\projectile\Egg as EggEntity;
use pocketmine\entity\projectile\Throwable;
use pocketmine\player\Player;

class Egg extends ProjectileItem{

	public function getMaxStackSize() : int{
		return 16;
	}

	protected function createEntity(Location $location, Player $thrower) : Throwable{
		return new EggEntity($location, $thrower);
	}

	public function getThrowForce() : float{
		return 1.5;
	}
}
