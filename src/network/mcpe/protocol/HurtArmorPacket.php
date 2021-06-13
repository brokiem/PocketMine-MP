<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class HurtArmorPacket extends DataPacket implements ClientboundPacket{
	public const NETWORK_ID = ProtocolInfo::HURT_ARMOR_PACKET;

	/** @var int */
	public $cause;
	/** @var int */
	public $health;

	protected function decodePayload(PacketSerializer $in) : void{
		$this->cause = $in->getVarInt();
		$this->health = $in->getVarInt();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putVarInt($this->cause);
		$out->putVarInt($this->health);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleHurtArmor($this);
	}
}
