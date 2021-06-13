<?php

declare(strict_types=1);

namespace pocketmine\entity\projectile;

use pocketmine\event\entity\ProjectileHitEvent;
use pocketmine\network\mcpe\protocol\types\entity\EntityIds;
use pocketmine\world\particle\SnowballPoofParticle;

class Snowball extends Throwable{
	public static function getNetworkTypeId() : string{ return EntityIds::SNOWBALL; }

	protected function onHit(ProjectileHitEvent $event) : void{
		for($i = 0; $i < 6; ++$i){
			$this->getWorld()->addParticle($this->location, new SnowballPoofParticle());
		}
	}
}
