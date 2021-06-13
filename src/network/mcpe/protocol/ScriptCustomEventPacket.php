<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class ScriptCustomEventPacket extends DataPacket{ //TODO: this doesn't have handlers in either client or server in the game as of 1.8
	public const NETWORK_ID = ProtocolInfo::SCRIPT_CUSTOM_EVENT_PACKET;

	/** @var string */
	public $eventName;
	/** @var string json data */
	public $eventData;

	protected function decodePayload(PacketSerializer $in) : void{
		$this->eventName = $in->getString();
		$this->eventData = $in->getString();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putString($this->eventName);
		$out->putString($this->eventData);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleScriptCustomEvent($this);
	}
}
