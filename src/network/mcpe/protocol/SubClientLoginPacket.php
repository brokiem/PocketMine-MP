<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class SubClientLoginPacket extends DataPacket implements ServerboundPacket{
	public const NETWORK_ID = ProtocolInfo::SUB_CLIENT_LOGIN_PACKET;

	/** @var string */
	public $connectionRequestData;

	protected function decodePayload(PacketSerializer $in) : void{
		$this->connectionRequestData = $in->getString();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putString($this->connectionRequestData);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleSubClientLogin($this);
	}
}
