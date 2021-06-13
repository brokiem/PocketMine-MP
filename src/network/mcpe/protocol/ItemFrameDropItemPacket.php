<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class ItemFrameDropItemPacket extends DataPacket implements ServerboundPacket{

	public const NETWORK_ID = ProtocolInfo::ITEM_FRAME_DROP_ITEM_PACKET;

	/** @var int */
	public $x;
	/** @var int */
	public $y;
	/** @var int */
	public $z;

	protected function decodePayload(PacketSerializer $in) : void{
		$in->getBlockPosition($this->x, $this->y, $this->z);
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putBlockPosition($this->x, $this->y, $this->z);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleItemFrameDropItem($this);
	}
}
