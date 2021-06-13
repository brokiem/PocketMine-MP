<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class NetworkStackLatencyPacket extends DataPacket implements ClientboundPacket, ServerboundPacket{
	public const NETWORK_ID = ProtocolInfo::NETWORK_STACK_LATENCY_PACKET;

	/** @var int */
	public $timestamp;
	/** @var bool */
	public $needResponse;

	public static function request(int $timestampNs) : self{
		$result = new self;
		$result->timestamp = $timestampNs;
		$result->needResponse = true;
		return $result;
	}

	public static function response(int $timestampNs) : self{
		$result = new self;
		$result->timestamp = $timestampNs;
		$result->needResponse = false;
		return $result;
	}

	protected function decodePayload(PacketSerializer $in) : void{
		$this->timestamp = $in->getLLong();
		$this->needResponse = $in->getBool();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putLLong($this->timestamp);
		$out->putBool($this->needResponse);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleNetworkStackLatency($this);
	}
}
