<?php

declare(strict_types=1);

namespace pocketmine\entity\projectile;

use pocketmine\event\entity\ProjectileHitEvent;
use pocketmine\item\VanillaItems;
use pocketmine\network\mcpe\protocol\types\entity\EntityIds;
use pocketmine\world\particle\ItemBreakParticle;

class Egg extends Throwable{
	public static function getNetworkTypeId() : string{ return EntityIds::EGG; }

	//TODO: spawn chickens on collision

	protected function onHit(ProjectileHitEvent $event) : void{
		for($i = 0; $i < 6; ++$i){
			$this->getWorld()->addParticle($this->location, new ItemBreakParticle(VanillaItems::EGG()));
		}
	}
}
