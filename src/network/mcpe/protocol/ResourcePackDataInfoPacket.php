<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;
use pocketmine\network\mcpe\protocol\types\resourcepacks\ResourcePackType;

class ResourcePackDataInfoPacket extends DataPacket implements ClientboundPacket{
	public const NETWORK_ID = ProtocolInfo::RESOURCE_PACK_DATA_INFO_PACKET;

	/** @var string */
	public $packId;
	/** @var int */
	public $maxChunkSize;
	/** @var int */
	public $chunkCount;
	/** @var int */
	public $compressedPackSize;
	/** @var string */
	public $sha256;
	/** @var bool */
	public $isPremium = false;
	/** @var int */
	public $packType = ResourcePackType::RESOURCES; //TODO: check the values for this

	public static function create(string $packId, int $maxChunkSize, int $chunkCount, int $compressedPackSize, string $sha256sum) : self{
		$result = new self;
		$result->packId = $packId;
		$result->maxChunkSize = $maxChunkSize;
		$result->chunkCount = $chunkCount;
		$result->compressedPackSize = $compressedPackSize;
		$result->sha256 = $sha256sum;
		return $result;
	}

	protected function decodePayload(PacketSerializer $in) : void{
		$this->packId = $in->getString();
		$this->maxChunkSize = $in->getLInt();
		$this->chunkCount = $in->getLInt();
		$this->compressedPackSize = $in->getLLong();
		$this->sha256 = $in->getString();
		$this->isPremium = $in->getBool();
		$this->packType = $in->getByte();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putString($this->packId);
		$out->putLInt($this->maxChunkSize);
		$out->putLInt($this->chunkCount);
		$out->putLLong($this->compressedPackSize);
		$out->putString($this->sha256);
		$out->putBool($this->isPremium);
		$out->putByte($this->packType);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleResourcePackDataInfo($this);
	}
}
