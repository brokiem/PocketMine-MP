<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class ActorPickRequestPacket extends DataPacket implements ServerboundPacket{
	public const NETWORK_ID = ProtocolInfo::ACTOR_PICK_REQUEST_PACKET;

	/** @var int */
	public $entityUniqueId;
	/** @var int */
	public $hotbarSlot;

	protected function decodePayload(PacketSerializer $in) : void{
		$this->entityUniqueId = $in->getLLong();
		$this->hotbarSlot = $in->getByte();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putLLong($this->entityUniqueId);
		$out->putByte($this->hotbarSlot);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleActorPickRequest($this);
	}
}
