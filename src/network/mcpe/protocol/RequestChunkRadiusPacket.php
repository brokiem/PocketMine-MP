<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class RequestChunkRadiusPacket extends DataPacket implements ServerboundPacket{
	public const NETWORK_ID = ProtocolInfo::REQUEST_CHUNK_RADIUS_PACKET;

	/** @var int */
	public $radius;

	protected function decodePayload(PacketSerializer $in) : void{
		$this->radius = $in->getVarInt();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putVarInt($this->radius);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleRequestChunkRadius($this);
	}
}
