<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class UpdateBlockPacket extends DataPacket implements ClientboundPacket{
	public const NETWORK_ID = ProtocolInfo::UPDATE_BLOCK_PACKET;

	public const DATA_LAYER_NORMAL = 0;
	public const DATA_LAYER_LIQUID = 1;

	/** @var int */
	public $x;
	/** @var int */
	public $z;
	/** @var int */
	public $y;
	/** @var int */
	public $blockRuntimeId;
	/**
	 * @var int
	 * Flags are used by MCPE internally for block setting, but only flag 2 (network flag) is relevant for network.
	 * This field is pointless really.
	 */
	public $flags = 0x02;
	/** @var int */
	public $dataLayerId = self::DATA_LAYER_NORMAL;

	public static function create(int $x, int $y, int $z, int $blockRuntimeId, int $dataLayerId = self::DATA_LAYER_NORMAL) : self{
		$result = new self;
		[$result->x, $result->y, $result->z] = [$x, $y, $z];
		$result->blockRuntimeId = $blockRuntimeId;
		$result->dataLayerId = $dataLayerId;
		return $result;
	}

	protected function decodePayload(PacketSerializer $in) : void{
		$in->getBlockPosition($this->x, $this->y, $this->z);
		$this->blockRuntimeId = $in->getUnsignedVarInt();
		$this->flags = $in->getUnsignedVarInt();
		$this->dataLayerId = $in->getUnsignedVarInt();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putBlockPosition($this->x, $this->y, $this->z);
		$out->putUnsignedVarInt($this->blockRuntimeId);
		$out->putUnsignedVarInt($this->flags);
		$out->putUnsignedVarInt($this->dataLayerId);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleUpdateBlock($this);
	}
}
