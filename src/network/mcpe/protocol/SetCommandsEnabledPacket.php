<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class SetCommandsEnabledPacket extends DataPacket implements ClientboundPacket{
	public const NETWORK_ID = ProtocolInfo::SET_COMMANDS_ENABLED_PACKET;

	/** @var bool */
	public $enabled;

	public static function create(bool $enabled) : self{
		$result = new self;
		$result->enabled = $enabled;
		return $result;
	}

	protected function decodePayload(PacketSerializer $in) : void{
		$this->enabled = $in->getBool();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putBool($this->enabled);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleSetCommandsEnabled($this);
	}
}
