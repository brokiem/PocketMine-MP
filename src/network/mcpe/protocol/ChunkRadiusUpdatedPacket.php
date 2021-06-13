<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class ChunkRadiusUpdatedPacket extends DataPacket implements ClientboundPacket{
	public const NETWORK_ID = ProtocolInfo::CHUNK_RADIUS_UPDATED_PACKET;

	/** @var int */
	public $radius;

	public static function create(int $radius) : self{
		$result = new self;
		$result->radius = $radius;
		return $result;
	}

	protected function decodePayload(PacketSerializer $in) : void{
		$this->radius = $in->getVarInt();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putVarInt($this->radius);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleChunkRadiusUpdated($this);
	}
}
