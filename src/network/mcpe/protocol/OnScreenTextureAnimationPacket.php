<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class OnScreenTextureAnimationPacket extends DataPacket implements ClientboundPacket{
	public const NETWORK_ID = ProtocolInfo::ON_SCREEN_TEXTURE_ANIMATION_PACKET;

	/** @var int */
	public $effectId;

	protected function decodePayload(PacketSerializer $in) : void{
		$this->effectId = $in->getLInt(); //unsigned
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putLInt($this->effectId);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleOnScreenTextureAnimation($this);
	}
}
