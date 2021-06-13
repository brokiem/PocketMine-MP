<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class ServerSettingsRequestPacket extends DataPacket implements ServerboundPacket{
	public const NETWORK_ID = ProtocolInfo::SERVER_SETTINGS_REQUEST_PACKET;

	protected function decodePayload(PacketSerializer $in) : void{
		//No payload
	}

	protected function encodePayload(PacketSerializer $out) : void{
		//No payload
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleServerSettingsRequest($this);
	}
}
