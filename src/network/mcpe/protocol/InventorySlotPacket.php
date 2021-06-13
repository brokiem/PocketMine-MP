<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;
use pocketmine\network\mcpe\protocol\types\inventory\ItemStackWrapper;

class InventorySlotPacket extends DataPacket implements ClientboundPacket{
	public const NETWORK_ID = ProtocolInfo::INVENTORY_SLOT_PACKET;

	/** @var int */
	public $windowId;
	/** @var int */
	public $inventorySlot;
	/** @var ItemStackWrapper */
	public $item;

	public static function create(int $windowId, int $slot, ItemStackWrapper $item) : self{
		$result = new self;
		$result->inventorySlot = $slot;
		$result->item = $item;
		$result->windowId = $windowId;

		return $result;
	}

	protected function decodePayload(PacketSerializer $in) : void{
		$this->windowId = $in->getUnsignedVarInt();
		$this->inventorySlot = $in->getUnsignedVarInt();
		$this->item = ItemStackWrapper::read($in);
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putUnsignedVarInt($this->windowId);
		$out->putUnsignedVarInt($this->inventorySlot);
		$this->item->write($out);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleInventorySlot($this);
	}
}
