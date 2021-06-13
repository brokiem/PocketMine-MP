<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class CorrectPlayerMovePredictionPacket extends DataPacket implements ClientboundPacket{
	public const NETWORK_ID = ProtocolInfo::CORRECT_PLAYER_MOVE_PREDICTION_PACKET;

	/** @var Vector3 */
	private $position;
	/** @var Vector3 */
	private $delta;
	/** @var bool */
	private $onGround;
	/** @var int */
	private $tick;

	public static function create(Vector3 $position, Vector3 $delta, bool $onGround, int $tick) : self{
		$result = new self;
		$result->position = $position;
		$result->delta = $delta;
		$result->onGround = $onGround;
		$result->tick = $tick;
		return $result;
	}

	public function getPosition() : Vector3{ return $this->position; }

	public function getDelta() : Vector3{ return $this->delta; }

	public function isOnGround() : bool{ return $this->onGround; }

	public function getTick() : int{ return $this->tick; }

	protected function decodePayload(PacketSerializer $in) : void{
		$this->position = $in->getVector3();
		$this->delta = $in->getVector3();
		$this->onGround = $in->getBool();
		$this->tick = $in->getUnsignedVarLong();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putVector3($this->position);
		$out->putVector3($this->delta);
		$out->putBool($this->onGround);
		$out->putUnsignedVarLong($this->tick);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleCorrectPlayerMovePrediction($this);
	}
}
