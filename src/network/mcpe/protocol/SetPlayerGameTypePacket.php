<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class SetPlayerGameTypePacket extends DataPacket implements ClientboundPacket, ServerboundPacket{
	public const NETWORK_ID = ProtocolInfo::SET_PLAYER_GAME_TYPE_PACKET;

	/** @var int */
	public $gamemode;

	public static function create(int $gamemode) : self{
		$pk = new self;
		$pk->gamemode = $gamemode;
		return $pk;
	}

	protected function decodePayload(PacketSerializer $in) : void{
		$this->gamemode = $in->getVarInt();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putVarInt($this->gamemode);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleSetPlayerGameType($this);
	}
}
