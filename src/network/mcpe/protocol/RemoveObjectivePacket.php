<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class RemoveObjectivePacket extends DataPacket implements ClientboundPacket{
	public const NETWORK_ID = ProtocolInfo::REMOVE_OBJECTIVE_PACKET;

	/** @var string */
	public $objectiveName;

	protected function decodePayload(PacketSerializer $in) : void{
		$this->objectiveName = $in->getString();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putString($this->objectiveName);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleRemoveObjective($this);
	}
}
