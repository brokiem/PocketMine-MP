<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class PlaySoundPacket extends DataPacket implements ClientboundPacket{
	public const NETWORK_ID = ProtocolInfo::PLAY_SOUND_PACKET;

	/** @var string */
	public $soundName;
	/** @var float */
	public $x;
	/** @var float */
	public $y;
	/** @var float */
	public $z;
	/** @var float */
	public $volume;
	/** @var float */
	public $pitch;

	protected function decodePayload(PacketSerializer $in) : void{
		$this->soundName = $in->getString();
		$in->getBlockPosition($this->x, $this->y, $this->z);
		$this->x /= 8;
		$this->y /= 8;
		$this->z /= 8;
		$this->volume = $in->getLFloat();
		$this->pitch = $in->getLFloat();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putString($this->soundName);
		$out->putBlockPosition((int) ($this->x * 8), (int) ($this->y * 8), (int) ($this->z * 8));
		$out->putLFloat($this->volume);
		$out->putLFloat($this->pitch);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handlePlaySound($this);
	}
}
