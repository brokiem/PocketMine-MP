<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class MapInfoRequestPacket extends DataPacket implements ServerboundPacket{
	public const NETWORK_ID = ProtocolInfo::MAP_INFO_REQUEST_PACKET;

	/** @var int */
	public $mapId;

	protected function decodePayload(PacketSerializer $in) : void{
		$this->mapId = $in->getEntityUniqueId();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putEntityUniqueId($this->mapId);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleMapInfoRequest($this);
	}
}
