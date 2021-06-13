<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;
use pocketmine\network\mcpe\protocol\types\GameMode;

class UpdatePlayerGameTypePacket extends DataPacket implements ClientboundPacket{
	public const NETWORK_ID = ProtocolInfo::UPDATE_PLAYER_GAME_TYPE_PACKET;

	/**
	 * @var int
	 * @see GameMode
	 */
	private $gameMode;

	/** @var int */
	private $playerEntityUniqueId;

	public static function create(int $gameMode, int $playerEntityUniqueId) : self{
		$result = new self;
		$result->gameMode = $gameMode;
		$result->playerEntityUniqueId = $playerEntityUniqueId;
		return $result;
	}

	public function getGameMode() : int{ return $this->gameMode; }

	public function getPlayerEntityUniqueId() : int{ return $this->playerEntityUniqueId; }

	protected function decodePayload(PacketSerializer $in) : void{
		$this->gameMode = $in->getVarInt();
		$this->playerEntityUniqueId = $in->getEntityUniqueId();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putVarInt($this->gameMode);
		$out->putEntityUniqueId($this->playerEntityUniqueId);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleUpdatePlayerGameType($this);
	}
}
