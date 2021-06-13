<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class MovePlayerPacket extends DataPacket implements ClientboundPacket, ServerboundPacket{
	public const NETWORK_ID = ProtocolInfo::MOVE_PLAYER_PACKET;

	public const MODE_NORMAL = 0;
	public const MODE_RESET = 1;
	public const MODE_TELEPORT = 2;
	public const MODE_PITCH = 3; //facepalm Mojang

	/** @var int */
	public $entityRuntimeId;
	/** @var Vector3 */
	public $position;
	/** @var float */
	public $pitch;
	/** @var float */
	public $yaw;
	/** @var float */
	public $headYaw;
	/** @var int */
	public $mode = self::MODE_NORMAL;
	/** @var bool */
	public $onGround = false; //TODO
	/** @var int */
	public $ridingEid = 0;
	/** @var int */
	public $teleportCause = 0;
	/** @var int */
	public $teleportItem = 0;
	/** @var int */
	public $tick = 0;

	protected function decodePayload(PacketSerializer $in) : void{
		$this->entityRuntimeId = $in->getEntityRuntimeId();
		$this->position = $in->getVector3();
		$this->pitch = $in->getLFloat();
		$this->yaw = $in->getLFloat();
		$this->headYaw = $in->getLFloat();
		$this->mode = $in->getByte();
		$this->onGround = $in->getBool();
		$this->ridingEid = $in->getEntityRuntimeId();
		if($this->mode === MovePlayerPacket::MODE_TELEPORT){
			$this->teleportCause = $in->getLInt();
			$this->teleportItem = $in->getLInt();
		}
		$this->tick = $in->getUnsignedVarLong();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putEntityRuntimeId($this->entityRuntimeId);
		$out->putVector3($this->position);
		$out->putLFloat($this->pitch);
		$out->putLFloat($this->yaw);
		$out->putLFloat($this->headYaw); //TODO
		$out->putByte($this->mode);
		$out->putBool($this->onGround);
		$out->putEntityRuntimeId($this->ridingEid);
		if($this->mode === MovePlayerPacket::MODE_TELEPORT){
			$out->putLInt($this->teleportCause);
			$out->putLInt($this->teleportItem);
		}
		$out->putUnsignedVarLong($this->tick);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleMovePlayer($this);
	}
}
