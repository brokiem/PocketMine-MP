<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class CameraShakePacket extends DataPacket implements ClientboundPacket{
	public const NETWORK_ID = ProtocolInfo::CAMERA_SHAKE_PACKET;

	public const TYPE_POSITIONAL = 0;
	public const TYPE_ROTATIONAL = 1;

	public const ACTION_ADD = 0;
	public const ACTION_STOP = 1;

	/** @var float */
	private $intensity;
	/** @var float */
	private $duration;
	/** @var int */
	private $shakeType;
	/** @var int */
	private $shakeAction;

	public static function create(float $intensity, float $duration, int $shakeType, int $shakeAction) : self{
		$result = new self;
		$result->intensity = $intensity;
		$result->duration = $duration;
		$result->shakeType = $shakeType;
		$result->shakeAction = $shakeAction;
		return $result;
	}

	public function getIntensity() : float{ return $this->intensity; }

	public function getDuration() : float{ return $this->duration; }

	public function getShakeType() : int{ return $this->shakeType; }

	public function getShakeAction() : int{ return $this->shakeAction; }

	protected function decodePayload(PacketSerializer $in) : void{
		$this->intensity = $in->getLFloat();
		$this->duration = $in->getLFloat();
		$this->shakeType = $in->getByte();
		if($in->getProtocolId() >= ProtocolInfo::PROTOCOL_1_16_210_57){
			$this->shakeAction = $in->getByte();
		}
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putLFloat($this->intensity);
		$out->putLFloat($this->duration);
		$out->putByte($this->shakeType);
		if($out->getProtocolId() >= ProtocolInfo::PROTOCOL_1_16_210_57){
			$out->putByte($this->shakeAction);
		}
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleCameraShake($this);
	}
}
