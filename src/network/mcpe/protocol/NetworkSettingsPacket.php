<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class NetworkSettingsPacket extends DataPacket implements ClientboundPacket{
	public const NETWORK_ID = ProtocolInfo::NETWORK_SETTINGS_PACKET;

	public const COMPRESS_NOTHING = 0;
	public const COMPRESS_EVERYTHING = 1;

	/** @var int */
	private $compressionThreshold;

	public static function create(int $compressionThreshold) : self{
		$result = new self;
		$result->compressionThreshold = $compressionThreshold;
		return $result;
	}

	public function getCompressionThreshold() : int{
		return $this->compressionThreshold;
	}

	protected function decodePayload(PacketSerializer $in) : void{
		$this->compressionThreshold = $in->getLShort();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putLShort($this->compressionThreshold);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleNetworkSettings($this);
	}
}
