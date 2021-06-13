<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class GuiDataPickItemPacket extends DataPacket implements ClientboundPacket{
	public const NETWORK_ID = ProtocolInfo::GUI_DATA_PICK_ITEM_PACKET;

	/** @var string */
	public $itemDescription;
	/** @var string */
	public $itemEffects;
	/** @var int */
	public $hotbarSlot;

	protected function decodePayload(PacketSerializer $in) : void{
		$this->itemDescription = $in->getString();
		$this->itemEffects = $in->getString();
		$this->hotbarSlot = $in->getLInt();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putString($this->itemDescription);
		$out->putString($this->itemEffects);
		$out->putLInt($this->hotbarSlot);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleGuiDataPickItem($this);
	}
}
