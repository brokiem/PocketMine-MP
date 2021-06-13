<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class StopSoundPacket extends DataPacket implements ClientboundPacket{
	public const NETWORK_ID = ProtocolInfo::STOP_SOUND_PACKET;

	/** @var string */
	public $soundName;
	/** @var bool */
	public $stopAll;

	protected function decodePayload(PacketSerializer $in) : void{
		$this->soundName = $in->getString();
		$this->stopAll = $in->getBool();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putString($this->soundName);
		$out->putBool($this->stopAll);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleStopSound($this);
	}
}
