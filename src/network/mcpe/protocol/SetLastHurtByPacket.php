<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class SetLastHurtByPacket extends DataPacket implements ClientboundPacket{
	public const NETWORK_ID = ProtocolInfo::SET_LAST_HURT_BY_PACKET;

	/** @var int */
	public $entityTypeId;

	protected function decodePayload(PacketSerializer $in) : void{
		$this->entityTypeId = $in->getVarInt();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putVarInt($this->entityTypeId);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleSetLastHurtBy($this);
	}
}
