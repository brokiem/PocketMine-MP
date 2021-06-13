<?php

declare(strict_types=1);

namespace pocketmine\world\sound;

use pocketmine\entity\Entity;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\LevelSoundEventPacket;

/**
 * Played when an entity hits ground after falling a long distance (damage).
 * This is the bone-breaker "crunch" sound.
 */
class EntityLongFallSound implements Sound{

	/** @var Entity */
	private $entity;

	public function __construct(Entity $entity){
		$this->entity = $entity;
	}

	public function encode(?Vector3 $pos) : array{
		return [LevelSoundEventPacket::create(
			LevelSoundEventPacket::SOUND_FALL_BIG,
			$pos,
			-1,
			$this->entity::getNetworkTypeId()
			//TODO: is isBaby relevant here?
		)];
	}
}
