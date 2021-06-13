<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class NetworkChunkPublisherUpdatePacket extends DataPacket implements ClientboundPacket{
	public const NETWORK_ID = ProtocolInfo::NETWORK_CHUNK_PUBLISHER_UPDATE_PACKET;

	/** @var int */
	public $x;
	/** @var int */
	public $y;
	/** @var int */
	public $z;
	/** @var int */
	public $radius;

	public static function create(int $x, int $y, int $z, int $blockRadius) : self{
		$result = new self;
		$result->x = $x;
		$result->y = $y;
		$result->z = $z;
		$result->radius = $blockRadius;
		return $result;
	}

	protected function decodePayload(PacketSerializer $in) : void{
		$in->getSignedBlockPosition($this->x, $this->y, $this->z);
		$this->radius = $in->getUnsignedVarInt();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putSignedBlockPosition($this->x, $this->y, $this->z);
		$out->putUnsignedVarInt($this->radius);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleNetworkChunkPublisherUpdate($this);
	}
}
