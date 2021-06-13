<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class CameraPacket extends DataPacket implements ClientboundPacket{
	public const NETWORK_ID = ProtocolInfo::CAMERA_PACKET;

	/** @var int */
	public $cameraUniqueId;
	/** @var int */
	public $playerUniqueId;

	protected function decodePayload(PacketSerializer $in) : void{
		$this->cameraUniqueId = $in->getEntityUniqueId();
		$this->playerUniqueId = $in->getEntityUniqueId();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putEntityUniqueId($this->cameraUniqueId);
		$out->putEntityUniqueId($this->playerUniqueId);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleCamera($this);
	}
}
