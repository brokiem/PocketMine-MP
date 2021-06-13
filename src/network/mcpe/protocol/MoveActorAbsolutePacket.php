<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class MoveActorAbsolutePacket extends DataPacket implements ClientboundPacket, ServerboundPacket{
	public const NETWORK_ID = ProtocolInfo::MOVE_ACTOR_ABSOLUTE_PACKET;

	public const FLAG_GROUND = 0x01;
	public const FLAG_TELEPORT = 0x02;
	public const FLAG_FORCE_MOVE_LOCAL_ENTITY = 0x04;

	/** @var int */
	public $entityRuntimeId;
	/** @var int */
	public $flags = 0;
	/** @var Vector3 */
	public $position;
	/** @var float */
	public $xRot;
	/** @var float */
	public $yRot;
	/** @var float */
	public $zRot;

	public static function create(int $entityRuntimeId, Vector3 $pos, float $xRot, float $yRot, float $zRot, int $flags = 0) : self{
		$result = new self;
		$result->entityRuntimeId = $entityRuntimeId;
		$result->position = $pos->asVector3();
		$result->xRot = $xRot;
		$result->yRot = $yRot;
		$result->zRot = $zRot;
		$result->flags = $flags;
		return $result;
	}

	protected function decodePayload(PacketSerializer $in) : void{
		$this->entityRuntimeId = $in->getEntityRuntimeId();
		$this->flags = $in->getByte();
		$this->position = $in->getVector3();
		$this->xRot = $in->getByteRotation();
		$this->yRot = $in->getByteRotation();
		$this->zRot = $in->getByteRotation();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putEntityRuntimeId($this->entityRuntimeId);
		$out->putByte($this->flags);
		$out->putVector3($this->position);
		$out->putByteRotation($this->xRot);
		$out->putByteRotation($this->yRot);
		$out->putByteRotation($this->zRot);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleMoveActorAbsolute($this);
	}
}
