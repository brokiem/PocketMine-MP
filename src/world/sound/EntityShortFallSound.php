<?php

declare(strict_types=1);

namespace pocketmine\world\sound;

use pocketmine\entity\Entity;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\LevelSoundEventPacket;

/**
 * Played when an entity hits the ground after falling a short distance.
 */
class EntityShortFallSound implements Sound{

	/** @var Entity */
	private $entity;

	public function __construct(Entity $entity){
		$this->entity = $entity;
	}

	public function encode(?Vector3 $pos) : array{
		return [LevelSoundEventPacket::create(
			LevelSoundEventPacket::SOUND_FALL_SMALL,
			$pos,
			-1,
			$this->entity::getNetworkTypeId()
			//TODO: does isBaby have any relevance here?
		)];
	}
}
