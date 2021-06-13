<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class TakeItemActorPacket extends DataPacket implements ClientboundPacket{
	public const NETWORK_ID = ProtocolInfo::TAKE_ITEM_ACTOR_PACKET;

	/** @var int */
	public $target;
	/** @var int */
	public $eid;

	public static function create(int $takerEntityRuntimeId, int $itemEntityRuntimeId) : self{
		$result = new self;
		$result->target = $itemEntityRuntimeId;
		$result->eid = $takerEntityRuntimeId;
		return $result;
	}

	protected function decodePayload(PacketSerializer $in) : void{
		$this->target = $in->getEntityRuntimeId();
		$this->eid = $in->getEntityRuntimeId();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putEntityRuntimeId($this->target);
		$out->putEntityRuntimeId($this->eid);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleTakeItemActor($this);
	}
}
