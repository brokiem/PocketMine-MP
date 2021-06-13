<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class DebugInfoPacket extends DataPacket implements ClientboundPacket, ServerboundPacket{
	public const NETWORK_ID = ProtocolInfo::DEBUG_INFO_PACKET;

	/** @var int */
	private $entityUniqueId;
	/** @var string */
	private $data;

	public static function create(int $entityUniqueId, string $data) : self{
		$result = new self;
		$result->entityUniqueId = $entityUniqueId;
		$result->data = $data;
		return $result;
	}

	/**
	 * TODO: we can't call this getEntityRuntimeId() because of base class collision (crap architecture, thanks Shoghi)
	 */
	public function getEntityUniqueIdField() : int{ return $this->entityUniqueId; }

	public function getData() : string{ return $this->data; }

	protected function decodePayload(PacketSerializer $in) : void{
		$this->entityUniqueId = $in->getEntityUniqueId();
		$this->data = $in->getString();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putEntityUniqueId($this->entityUniqueId);
		$out->putString($this->data);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleDebugInfo($this);
	}
}
