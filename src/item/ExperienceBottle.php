<?php

declare(strict_types=1);

namespace pocketmine\item;

use pocketmine\entity\Location;
use pocketmine\entity\projectile\ExperienceBottle as ExperienceBottleEntity;
use pocketmine\entity\projectile\Throwable;
use pocketmine\player\Player;

class ExperienceBottle extends ProjectileItem{

	protected function createEntity(Location $location, Player $thrower) : Throwable{
		return new ExperienceBottleEntity($location, $thrower);
	}

	public function getThrowForce() : float{
		return 0.7;
	}
}
