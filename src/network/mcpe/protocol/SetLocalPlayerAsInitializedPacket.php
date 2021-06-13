<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class SetLocalPlayerAsInitializedPacket extends DataPacket implements ServerboundPacket{
	public const NETWORK_ID = ProtocolInfo::SET_LOCAL_PLAYER_AS_INITIALIZED_PACKET;

	/** @var int */
	public $entityRuntimeId;

	protected function decodePayload(PacketSerializer $in) : void{
		$this->entityRuntimeId = $in->getEntityRuntimeId();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putEntityRuntimeId($this->entityRuntimeId);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleSetLocalPlayerAsInitialized($this);
	}
}
