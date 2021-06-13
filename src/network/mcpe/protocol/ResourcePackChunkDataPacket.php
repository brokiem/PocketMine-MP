<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class ResourcePackChunkDataPacket extends DataPacket implements ClientboundPacket{
	public const NETWORK_ID = ProtocolInfo::RESOURCE_PACK_CHUNK_DATA_PACKET;

	/** @var string */
	public $packId;
	/** @var int */
	public $chunkIndex;
	/** @var int */
	public $progress;
	/** @var string */
	public $data;

	public static function create(string $packId, int $chunkIndex, int $chunkOffset, string $data) : self{
		$result = new self;
		$result->packId = $packId;
		$result->chunkIndex = $chunkIndex;
		$result->progress = $chunkOffset;
		$result->data = $data;
		return $result;
	}

	protected function decodePayload(PacketSerializer $in) : void{
		$this->packId = $in->getString();
		$this->chunkIndex = $in->getLInt();
		$this->progress = $in->getLLong();
		$this->data = $in->getString();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putString($this->packId);
		$out->putLInt($this->chunkIndex);
		$out->putLLong($this->progress);
		$out->putString($this->data);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleResourcePackChunkData($this);
	}
}
