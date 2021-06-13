<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class SetTimePacket extends DataPacket implements ClientboundPacket{
	public const NETWORK_ID = ProtocolInfo::SET_TIME_PACKET;

	/** @var int */
	public $time;

	public static function create(int $time) : self{
		$result = new self;
		$result->time = $time & 0xffffffff; //avoid overflowing the field, since the packet uses an int32
		return $result;
	}

	protected function decodePayload(PacketSerializer $in) : void{
		$this->time = $in->getVarInt();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putVarInt($this->time);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleSetTime($this);
	}
}
