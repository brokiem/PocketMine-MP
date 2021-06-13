<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class ServerToClientHandshakePacket extends DataPacket implements ClientboundPacket{
	public const NETWORK_ID = ProtocolInfo::SERVER_TO_CLIENT_HANDSHAKE_PACKET;

	/**
	 * @var string
	 * Server pubkey and token is contained in the JWT.
	 */
	public $jwt;

	public static function create(string $jwt) : self{
		$result = new self;
		$result->jwt = $jwt;
		return $result;
	}

	public function canBeSentBeforeLogin() : bool{
		return true;
	}

	protected function decodePayload(PacketSerializer $in) : void{
		$this->jwt = $in->getString();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putString($this->jwt);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleServerToClientHandshake($this);
	}
}
