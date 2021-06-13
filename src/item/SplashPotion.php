<?php

declare(strict_types=1);

namespace pocketmine\item;

use pocketmine\entity\Location;
use pocketmine\entity\projectile\SplashPotion as SplashPotionEntity;
use pocketmine\entity\projectile\Throwable;
use pocketmine\player\Player;

class SplashPotion extends ProjectileItem{

	/** @var int */
	private $potionId;

	public function __construct(ItemIdentifier $identifier, string $name, int $potionId){
		parent::__construct($identifier, $name);
		$this->potionId = $potionId;
	}

	public function getMaxStackSize() : int{
		return 1;
	}

	protected function createEntity(Location $location, Player $thrower) : Throwable{
		$projectile = new SplashPotionEntity($location, $thrower);
		$projectile->setPotionId($this->potionId);
		return $projectile;
	}

	public function getThrowForce() : float{
		return 0.5;
	}
}
