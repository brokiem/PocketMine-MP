<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class MapCreateLockedCopyPacket extends DataPacket implements ServerboundPacket{
	public const NETWORK_ID = ProtocolInfo::MAP_CREATE_LOCKED_COPY_PACKET;

	/** @var int */
	public $originalMapId;
	/** @var int */
	public $newMapId;

	protected function decodePayload(PacketSerializer $in) : void{
		$this->originalMapId = $in->getEntityUniqueId();
		$this->newMapId = $in->getEntityUniqueId();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putEntityUniqueId($this->originalMapId);
		$out->putEntityUniqueId($this->newMapId);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleMapCreateLockedCopy($this);
	}
}
