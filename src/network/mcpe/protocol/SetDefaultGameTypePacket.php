<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class SetDefaultGameTypePacket extends DataPacket implements ClientboundPacket, ServerboundPacket{
	public const NETWORK_ID = ProtocolInfo::SET_DEFAULT_GAME_TYPE_PACKET;

	/** @var int */
	public $gamemode;

	public static function create(int $gameMode) : self{
		$result = new self;
		$result->gamemode = $gameMode;
		return $result;
	}

	protected function decodePayload(PacketSerializer $in) : void{
		$this->gamemode = $in->getVarInt();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putUnsignedVarInt($this->gamemode);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleSetDefaultGameType($this);
	}
}
