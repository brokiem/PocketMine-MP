<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class PlayerInputPacket extends DataPacket implements ServerboundPacket{
	public const NETWORK_ID = ProtocolInfo::PLAYER_INPUT_PACKET;

	/** @var float */
	public $motionX;
	/** @var float */
	public $motionY;
	/** @var bool */
	public $jumping;
	/** @var bool */
	public $sneaking;

	protected function decodePayload(PacketSerializer $in) : void{
		$this->motionX = $in->getLFloat();
		$this->motionY = $in->getLFloat();
		$this->jumping = $in->getBool();
		$this->sneaking = $in->getBool();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putLFloat($this->motionX);
		$out->putLFloat($this->motionY);
		$out->putBool($this->jumping);
		$out->putBool($this->sneaking);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handlePlayerInput($this);
	}
}
