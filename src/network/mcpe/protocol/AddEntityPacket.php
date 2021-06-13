<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class AddEntityPacket extends DataPacket implements ClientboundPacket{
	public const NETWORK_ID = ProtocolInfo::ADD_ENTITY_PACKET;

	/** @var int */
	private $entityNetId;

	public static function create(int $entityNetId) : self{
		$result = new self;
		$result->entityNetId = $entityNetId;
		return $result;
	}

	public function getEntityNetId() : int{
		return $this->entityNetId;
	}

	protected function decodePayload(PacketSerializer $in) : void{
		$this->entityNetId = $in->getUnsignedVarInt();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putUnsignedVarInt($this->entityNetId);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleAddEntity($this);
	}
}
