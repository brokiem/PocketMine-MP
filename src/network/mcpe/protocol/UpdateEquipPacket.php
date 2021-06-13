<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;
use pocketmine\network\mcpe\protocol\types\CacheableNbt;

class UpdateEquipPacket extends DataPacket implements ClientboundPacket{
	public const NETWORK_ID = ProtocolInfo::UPDATE_EQUIP_PACKET;

	/** @var int */
	public $windowId;
	/** @var int */
	public $windowType;
	/** @var int */
	public $windowSlotCount; //useless, seems to be part of a standard container header
	/** @var int */
	public $entityUniqueId;
	/**
	 * @var CacheableNbt
	 * @phpstan-var CacheableNbt<\pocketmine\nbt\tag\CompoundTag>
	 */
	public $namedtag;

	protected function decodePayload(PacketSerializer $in) : void{
		$this->windowId = $in->getByte();
		$this->windowType = $in->getByte();
		$this->windowSlotCount = $in->getVarInt();
		$this->entityUniqueId = $in->getEntityUniqueId();
		$this->namedtag = new CacheableNbt($in->getNbtCompoundRoot());
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putByte($this->windowId);
		$out->putByte($this->windowType);
		$out->putVarInt($this->windowSlotCount);
		$out->putEntityUniqueId($this->entityUniqueId);
		$out->put($this->namedtag->getEncodedNbt());
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleUpdateEquip($this);
	}
}
