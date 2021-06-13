<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class SimpleEventPacket extends DataPacket implements ClientboundPacket, ServerboundPacket{
	public const NETWORK_ID = ProtocolInfo::SIMPLE_EVENT_PACKET;

	public const TYPE_ENABLE_COMMANDS = 1;
	public const TYPE_DISABLE_COMMANDS = 2;
	public const TYPE_UNLOCK_WORLD_TEMPLATE_SETTINGS = 3;

	/** @var int */
	public $eventType;

	protected function decodePayload(PacketSerializer $in) : void{
		$this->eventType = $in->getLShort();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putLShort($this->eventType);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleSimpleEvent($this);
	}
}
