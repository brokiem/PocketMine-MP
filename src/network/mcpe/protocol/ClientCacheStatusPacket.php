<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class ClientCacheStatusPacket extends DataPacket implements ServerboundPacket{
	public const NETWORK_ID = ProtocolInfo::CLIENT_CACHE_STATUS_PACKET;

	/** @var bool */
	private $enabled;

	public static function create(bool $enabled) : self{
		$result = new self;
		$result->enabled = $enabled;
		return $result;
	}

	public function isEnabled() : bool{
		return $this->enabled;
	}

	protected function decodePayload(PacketSerializer $in) : void{
		$this->enabled = $in->getBool();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putBool($this->enabled);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleClientCacheStatus($this);
	}
}
