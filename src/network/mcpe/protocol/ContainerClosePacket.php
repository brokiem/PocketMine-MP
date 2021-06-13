<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class ContainerClosePacket extends DataPacket implements ClientboundPacket, ServerboundPacket{
	public const NETWORK_ID = ProtocolInfo::CONTAINER_CLOSE_PACKET;

	/** @var int */
	public $windowId;
	/** @var bool */
	public $server = false;

	public static function create(int $windowId, bool $server) : self{
		$result = new self;
		$result->windowId = $windowId;
		$result->server = $server;
		return $result;
	}

	protected function decodePayload(PacketSerializer $in) : void{
		$this->windowId = $in->getByte();
		$this->server = $in->getBool();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putByte($this->windowId);
		$out->putBool($this->server);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleContainerClose($this);
	}
}
