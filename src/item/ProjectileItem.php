<?php

declare(strict_types=1);

namespace pocketmine\item;

use pocketmine\entity\Location;
use pocketmine\entity\projectile\Throwable;
use pocketmine\event\entity\ProjectileLaunchEvent;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\world\sound\ThrowSound;

abstract class ProjectileItem extends Item{

	abstract public function getThrowForce() : float;

	abstract protected function createEntity(Location $location, Player $thrower) : Throwable;

	public function onClickAir(Player $player, Vector3 $directionVector) : ItemUseResult{
		$location = $player->getLocation();

		$projectile = $this->createEntity(Location::fromObject($player->getEyePos(), $player->getWorld(), $location->yaw, $location->pitch), $player);
		$projectile->setMotion($directionVector->multiply($this->getThrowForce()));

		$projectileEv = new ProjectileLaunchEvent($projectile);
		$projectileEv->call();
		if($projectileEv->isCancelled()){
			$projectile->flagForDespawn();
			return ItemUseResult::FAIL();
		}

		$projectile->spawnToAll();

		$location->getWorld()->addSound($location, new ThrowSound());

		$this->pop();

		return ItemUseResult::SUCCESS();
	}
}
