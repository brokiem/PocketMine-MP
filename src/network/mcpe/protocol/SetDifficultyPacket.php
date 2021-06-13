<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class SetDifficultyPacket extends DataPacket implements ClientboundPacket, ServerboundPacket{
	public const NETWORK_ID = ProtocolInfo::SET_DIFFICULTY_PACKET;

	/** @var int */
	public $difficulty;

	public static function create(int $difficulty) : self{
		$result = new self;
		$result->difficulty = $difficulty;
		return $result;
	}

	protected function decodePayload(PacketSerializer $in) : void{
		$this->difficulty = $in->getUnsignedVarInt();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putUnsignedVarInt($this->difficulty);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleSetDifficulty($this);
	}
}
