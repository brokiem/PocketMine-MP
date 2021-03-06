<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;
use pocketmine\network\mcpe\protocol\types\DimensionIds;

class SpawnParticleEffectPacket extends DataPacket implements ClientboundPacket{
	public const NETWORK_ID = ProtocolInfo::SPAWN_PARTICLE_EFFECT_PACKET;

	/** @var int */
	public $dimensionId = DimensionIds::OVERWORLD; //wtf mojang
	/** @var int */
	public $entityUniqueId = -1; //default none
	/** @var Vector3 */
	public $position;
	/** @var string */
	public $particleName;

	protected function decodePayload(PacketSerializer $in) : void{
		$this->dimensionId = $in->getByte();
		$this->entityUniqueId = $in->getEntityUniqueId();
		$this->position = $in->getVector3();
		$this->particleName = $in->getString();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putByte($this->dimensionId);
		$out->putEntityUniqueId($this->entityUniqueId);
		$out->putVector3($this->position);
		$out->putString($this->particleName);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleSpawnParticleEffect($this);
	}
}
