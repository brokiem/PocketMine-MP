<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

/**
 * Useless leftover from a 1.9 refactor, does nothing
 */
class LevelSoundEventPacketV2 extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::LEVEL_SOUND_EVENT_PACKET_V2;

	/** @var int */
	public $sound;
	/** @var Vector3 */
	public $position;
	/** @var int */
	public $extraData = -1;
	/** @var string */
	public $entityType = ":"; //???
	/** @var bool */
	public $isBabyMob = false; //...
	/** @var bool */
	public $disableRelativeVolume = false;

	protected function decodePayload(PacketSerializer $in) : void{
		$this->sound = $in->getByte();
		$this->position = $in->getVector3();
		$this->extraData = $in->getVarInt();
		$this->entityType = $in->getString();
		$this->isBabyMob = $in->getBool();
		$this->disableRelativeVolume = $in->getBool();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putByte($this->sound);
		$out->putVector3($this->position);
		$out->putVarInt($this->extraData);
		$out->putString($this->entityType);
		$out->putBool($this->isBabyMob);
		$out->putBool($this->disableRelativeVolume);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleLevelSoundEventPacketV2($this);
	}
}
