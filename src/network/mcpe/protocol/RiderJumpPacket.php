<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class RiderJumpPacket extends DataPacket implements ServerboundPacket{
	public const NETWORK_ID = ProtocolInfo::RIDER_JUMP_PACKET;

	/** @var int */
	public $jumpStrength; //percentage

	protected function decodePayload(PacketSerializer $in) : void{
		$this->jumpStrength = $in->getVarInt();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putVarInt($this->jumpStrength);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleRiderJump($this);
	}
}
