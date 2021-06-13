<?php

declare(strict_types=1);

namespace pocketmine\entity;

use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\network\mcpe\protocol\types\entity\EntityMetadataCollection;
use pocketmine\network\mcpe\protocol\types\entity\EntityMetadataFlags;

abstract class WaterAnimal extends Living implements Ageable{
	/** @var bool */
	protected $baby = false;

	public function isBaby() : bool{
		return $this->baby;
	}

	public function canBreathe() : bool{
		return $this->isUnderwater();
	}

	public function onAirExpired() : void{
		$ev = new EntityDamageEvent($this, EntityDamageEvent::CAUSE_SUFFOCATION, 2);
		$this->attack($ev);
	}

	protected function syncNetworkData(EntityMetadataCollection $properties) : void{
		parent::syncNetworkData($properties);
		$properties->setGenericFlag(EntityMetadataFlags::BABY, $this->baby);
	}
}
