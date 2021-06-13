<?php

declare(strict_types=1);

namespace pocketmine\world\sound;

use pocketmine\block\Block;
use pocketmine\entity\Entity;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\convert\RuntimeBlockMapping;
use pocketmine\network\mcpe\protocol\LevelSoundEventPacket;

/**
 * Played when an entity hits the ground after falling a distance that doesn't cause damage, e.g. due to jumping.
 */
class EntityLandSound extends MappingSound{

	/** @var Entity */
	private $entity;
	/** @var Block */
	private $blockLandedOn;

	public function __construct(Entity $entity, Block $blockLandedOn){
		$this->entity = $entity;
		$this->blockLandedOn = $blockLandedOn;
	}

	public function encode(?Vector3 $pos) : array{
		return [LevelSoundEventPacket::create(
			LevelSoundEventPacket::SOUND_LAND,
			$pos,
			RuntimeBlockMapping::getInstance()->toRuntimeId($this->blockLandedOn->getFullId(), $this->mappingProtocol),
			$this->entity::getNetworkTypeId()
			//TODO: does isBaby have any relevance here?
		)];
	}
}
