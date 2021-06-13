<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class LabTablePacket extends DataPacket implements ClientboundPacket, ServerboundPacket{
	public const NETWORK_ID = ProtocolInfo::LAB_TABLE_PACKET;

	public const TYPE_START_COMBINE = 0;
	public const TYPE_START_REACTION = 1;
	public const TYPE_RESET = 2;

	/** @var int */
	public $type;

	/** @var int */
	public $x;
	/** @var int */
	public $y;
	/** @var int */
	public $z;

	/** @var int */
	public $reactionType;

	protected function decodePayload(PacketSerializer $in) : void{
		$this->type = $in->getByte();
		$in->getSignedBlockPosition($this->x, $this->y, $this->z);
		$this->reactionType = $in->getByte();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putByte($this->type);
		$out->putSignedBlockPosition($this->x, $this->y, $this->z);
		$out->putByte($this->reactionType);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleLabTable($this);
	}
}
