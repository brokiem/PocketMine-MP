<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class AutomationClientConnectPacket extends DataPacket implements ClientboundPacket{
	public const NETWORK_ID = ProtocolInfo::AUTOMATION_CLIENT_CONNECT_PACKET;

	/** @var string */
	public $serverUri;

	protected function decodePayload(PacketSerializer $in) : void{
		$this->serverUri = $in->getString();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putString($this->serverUri);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleAutomationClientConnect($this);
	}
}
