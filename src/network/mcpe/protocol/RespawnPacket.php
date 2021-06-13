<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class RespawnPacket extends DataPacket implements ClientboundPacket, ServerboundPacket{
	public const NETWORK_ID = ProtocolInfo::RESPAWN_PACKET;

	public const SEARCHING_FOR_SPAWN = 0;
	public const READY_TO_SPAWN = 1;
	public const CLIENT_READY_TO_SPAWN = 2;

	/** @var Vector3 */
	public $position;
	/** @var int */
	public $respawnState = self::SEARCHING_FOR_SPAWN;
	/** @var int */
	public $entityRuntimeId;

	public static function create(Vector3 $position, int $respawnStatus, int $entityRuntimeId) : self{
		$result = new self;
		$result->position = $position->asVector3();
		$result->respawnState = $respawnStatus;
		$result->entityRuntimeId = $entityRuntimeId;
		return $result;
	}

	protected function decodePayload(PacketSerializer $in) : void{
		$this->position = $in->getVector3();
		$this->respawnState = $in->getByte();
		$this->entityRuntimeId = $in->getEntityRuntimeId();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putVector3($this->position);
		$out->putByte($this->respawnState);
		$out->putEntityRuntimeId($this->entityRuntimeId);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleRespawn($this);
	}
}
