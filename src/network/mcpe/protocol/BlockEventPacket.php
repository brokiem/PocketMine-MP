<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class BlockEventPacket extends DataPacket implements ClientboundPacket{
	public const NETWORK_ID = ProtocolInfo::BLOCK_EVENT_PACKET;

	/** @var int */
	public $x;
	/** @var int */
	public $y;
	/** @var int */
	public $z;
	/** @var int */
	public $eventType;
	/** @var int */
	public $eventData;

	public static function create(int $eventId, int $eventData, Vector3 $pos) : self{
		$pk = new self;
		$pk->eventType = $eventId;
		$pk->eventData = $eventData;
		$pk->x = $pos->getFloorX();
		$pk->y = $pos->getFloorY();
		$pk->z = $pos->getFloorZ();
		return $pk;
	}

	protected function decodePayload(PacketSerializer $in) : void{
		$in->getBlockPosition($this->x, $this->y, $this->z);
		$this->eventType = $in->getVarInt();
		$this->eventData = $in->getVarInt();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putBlockPosition($this->x, $this->y, $this->z);
		$out->putVarInt($this->eventType);
		$out->putVarInt($this->eventData);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleBlockEvent($this);
	}
}
