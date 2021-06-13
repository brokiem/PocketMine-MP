<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class SpawnExperienceOrbPacket extends DataPacket implements ServerboundPacket{
	public const NETWORK_ID = ProtocolInfo::SPAWN_EXPERIENCE_ORB_PACKET;

	/** @var Vector3 */
	public $position;
	/** @var int */
	public $amount;

	protected function decodePayload(PacketSerializer $in) : void{
		$this->position = $in->getVector3();
		$this->amount = $in->getVarInt();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putVector3($this->position);
		$out->putVarInt($this->amount);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleSpawnExperienceOrb($this);
	}
}
