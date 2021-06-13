<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;
use pocketmine\network\mcpe\protocol\types\GameRule;

class GameRulesChangedPacket extends DataPacket implements ClientboundPacket{
	public const NETWORK_ID = ProtocolInfo::GAME_RULES_CHANGED_PACKET;

	/**
	 * @var GameRule[]
	 * @phpstan-var array<string, GameRule>
	 */
	public $gameRules = [];

	protected function decodePayload(PacketSerializer $in) : void{
		$this->gameRules = $in->getGameRules();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putGameRules($this->gameRules);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleGameRulesChanged($this);
	}
}
