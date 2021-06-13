<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;
use pocketmine\network\mcpe\protocol\types\inventory\ItemStackWrapper;

class MobEquipmentPacket extends DataPacket implements ClientboundPacket, ServerboundPacket{
	public const NETWORK_ID = ProtocolInfo::MOB_EQUIPMENT_PACKET;

	/** @var int */
	public $entityRuntimeId;
	/** @var ItemStackWrapper */
	public $item;
	/** @var int */
	public $inventorySlot;
	/** @var int */
	public $hotbarSlot;
	/** @var int */
	public $windowId = 0;

	public static function create(int $entityRuntimeId, ItemStackWrapper $item, int $inventorySlot, int $windowId) : self{
		$result = new self;
		$result->entityRuntimeId = $entityRuntimeId;
		$result->item = $item;
		$result->inventorySlot = $inventorySlot;
		$result->hotbarSlot = $inventorySlot;
		$result->windowId = $windowId;
		return $result;
	}

	protected function decodePayload(PacketSerializer $in) : void{
		$this->entityRuntimeId = $in->getEntityRuntimeId();
		if($in->getProtocolId() >= ProtocolInfo::PROTOCOL_1_16_220){
			$this->item = ItemStackWrapper::read($in);
		}else{
			$this->item = ItemStackWrapper::legacy($in->getItemStackWithoutStackId());
		}
		$this->inventorySlot = $in->getByte();
		$this->hotbarSlot = $in->getByte();
		$this->windowId = $in->getByte();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putEntityRuntimeId($this->entityRuntimeId);
		if($out->getProtocolId() >= ProtocolInfo::PROTOCOL_1_16_220){
			$this->item->write($out);
		}else{
			$out->putItemStackWithoutStackId($this->item->getItemStack());
		}
		$out->putByte($this->inventorySlot);
		$out->putByte($this->hotbarSlot);
		$out->putByte($this->windowId);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleMobEquipment($this);
	}
}
