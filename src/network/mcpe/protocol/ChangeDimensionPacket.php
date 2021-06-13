<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class ChangeDimensionPacket extends DataPacket implements ClientboundPacket{
	public const NETWORK_ID = ProtocolInfo::CHANGE_DIMENSION_PACKET;

	/** @var int */
	public $dimension;
	/** @var Vector3 */
	public $position;
	/** @var bool */
	public $respawn = false;

	protected function decodePayload(PacketSerializer $in) : void{
		$this->dimension = $in->getVarInt();
		$this->position = $in->getVector3();
		$this->respawn = $in->getBool();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putVarInt($this->dimension);
		$out->putVector3($this->position);
		$out->putBool($this->respawn);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleChangeDimension($this);
	}
}
