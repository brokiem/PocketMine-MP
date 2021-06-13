<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class ResourcePackChunkRequestPacket extends DataPacket implements ServerboundPacket{
	public const NETWORK_ID = ProtocolInfo::RESOURCE_PACK_CHUNK_REQUEST_PACKET;

	/** @var string */
	public $packId;
	/** @var int */
	public $chunkIndex;

	protected function decodePayload(PacketSerializer $in) : void{
		$this->packId = $in->getString();
		$this->chunkIndex = $in->getLInt();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putString($this->packId);
		$out->putLInt($this->chunkIndex);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleResourcePackChunkRequest($this);
	}
}
