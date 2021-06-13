<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class ShowCreditsPacket extends DataPacket implements ClientboundPacket, ServerboundPacket{
	public const NETWORK_ID = ProtocolInfo::SHOW_CREDITS_PACKET;

	public const STATUS_START_CREDITS = 0;
	public const STATUS_END_CREDITS = 1;

	/** @var int */
	public $playerEid;
	/** @var int */
	public $status;

	protected function decodePayload(PacketSerializer $in) : void{
		$this->playerEid = $in->getEntityRuntimeId();
		$this->status = $in->getVarInt();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putEntityRuntimeId($this->playerEid);
		$out->putVarInt($this->status);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleShowCredits($this);
	}
}
