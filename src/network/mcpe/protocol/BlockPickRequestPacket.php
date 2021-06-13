<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class BlockPickRequestPacket extends DataPacket implements ServerboundPacket{
	public const NETWORK_ID = ProtocolInfo::BLOCK_PICK_REQUEST_PACKET;

	/** @var int */
	public $blockX;
	/** @var int */
	public $blockY;
	/** @var int */
	public $blockZ;
	/** @var bool */
	public $addUserData = false;
	/** @var int */
	public $hotbarSlot;

	protected function decodePayload(PacketSerializer $in) : void{
		$in->getSignedBlockPosition($this->blockX, $this->blockY, $this->blockZ);
		$this->addUserData = $in->getBool();
		$this->hotbarSlot = $in->getByte();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putSignedBlockPosition($this->blockX, $this->blockY, $this->blockZ);
		$out->putBool($this->addUserData);
		$out->putByte($this->hotbarSlot);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleBlockPickRequest($this);
	}
}
