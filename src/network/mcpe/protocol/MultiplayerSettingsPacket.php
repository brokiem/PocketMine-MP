<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class MultiplayerSettingsPacket extends DataPacket implements ClientboundPacket, ServerboundPacket{
	public const NETWORK_ID = ProtocolInfo::MULTIPLAYER_SETTINGS_PACKET;

	public const ACTION_ENABLE_MULTIPLAYER = 0;
	public const ACTION_DISABLE_MULTIPLAYER = 1;
	public const ACTION_REFRESH_JOIN_CODE = 2;

	/** @var int */
	private $action;

	public static function create(int $action) : self{
		$result = new self;
		$result->action = $action;
		return $result;
	}

	public function getAction() : int{
		return $this->action;
	}

	protected function decodePayload(PacketSerializer $in) : void{
		$this->action = $in->getVarInt();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putVarInt($this->action);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleMultiplayerSettings($this);
	}
}
