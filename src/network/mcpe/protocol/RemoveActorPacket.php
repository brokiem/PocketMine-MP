<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class RemoveActorPacket extends DataPacket implements ClientboundPacket{
	public const NETWORK_ID = ProtocolInfo::REMOVE_ACTOR_PACKET;

	/** @var int */
	public $entityUniqueId;

	public static function create(int $entityUniqueId) : self{
		$result = new self;
		$result->entityUniqueId = $entityUniqueId;
		return $result;
	}

	protected function decodePayload(PacketSerializer $in) : void{
		$this->entityUniqueId = $in->getEntityUniqueId();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putEntityUniqueId($this->entityUniqueId);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleRemoveActor($this);
	}
}
