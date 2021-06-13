<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class SetActorMotionPacket extends DataPacket implements ClientboundPacket, ServerboundPacket{
	public const NETWORK_ID = ProtocolInfo::SET_ACTOR_MOTION_PACKET;

	/** @var int */
	public $entityRuntimeId;
	/** @var Vector3 */
	public $motion;

	public static function create(int $entityRuntimeId, Vector3 $motion) : self{
		$result = new self;
		$result->entityRuntimeId = $entityRuntimeId;
		$result->motion = $motion->asVector3();
		return $result;
	}

	protected function decodePayload(PacketSerializer $in) : void{
		$this->entityRuntimeId = $in->getEntityRuntimeId();
		$this->motion = $in->getVector3();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putEntityRuntimeId($this->entityRuntimeId);
		$out->putVector3($this->motion);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleSetActorMotion($this);
	}
}
