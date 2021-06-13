<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class MotionPredictionHintsPacket extends DataPacket implements ClientboundPacket{
	public const NETWORK_ID = ProtocolInfo::MOTION_PREDICTION_HINTS_PACKET;

	/** @var int */
	private $entityRuntimeId;
	/** @var Vector3 */
	private $motion;
	/** @var bool */
	private $onGround;

	public static function create(int $entityRuntimeId, Vector3 $motion, bool $onGround) : self{
		$result = new self;
		$result->entityRuntimeId = $entityRuntimeId;
		$result->motion = $motion;
		$result->onGround = $onGround;
		return $result;
	}

	public function getEntityRuntimeId() : int{ return $this->entityRuntimeId; }

	public function getMotion() : Vector3{ return $this->motion; }

	public function isOnGround() : bool{ return $this->onGround; }

	protected function decodePayload(PacketSerializer $in) : void{
		$this->entityRuntimeId = $in->getEntityRuntimeId();
		$this->motion = $in->getVector3();
		$this->onGround = $in->getBool();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putEntityRuntimeId($this->entityRuntimeId);
		$out->putVector3($this->motion);
		$out->putBool($this->onGround);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleMotionPredictionHints($this);
	}
}
