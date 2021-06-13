<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class ShowProfilePacket extends DataPacket implements ClientboundPacket{
	public const NETWORK_ID = ProtocolInfo::SHOW_PROFILE_PACKET;

	/** @var string */
	public $xuid;

	protected function decodePayload(PacketSerializer $in) : void{
		$this->xuid = $in->getString();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putString($this->xuid);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleShowProfile($this);
	}
}
