<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;
use pocketmine\network\mcpe\protocol\types\inventory\ContainerIds;

class PlayerHotbarPacket extends DataPacket implements ClientboundPacket, ServerboundPacket{
	public const NETWORK_ID = ProtocolInfo::PLAYER_HOTBAR_PACKET;

	/** @var int */
	public $selectedHotbarSlot;
	/** @var int */
	public $windowId = ContainerIds::INVENTORY;
	/** @var bool */
	public $selectHotbarSlot = true;

	public static function create(int $slot, int $windowId, bool $selectSlot = true) : self{
		$result = new self;
		$result->selectedHotbarSlot = $slot;
		$result->windowId = $windowId;
		$result->selectHotbarSlot = $selectSlot;
		return $result;
	}

	protected function decodePayload(PacketSerializer $in) : void{
		$this->selectedHotbarSlot = $in->getUnsignedVarInt();
		$this->windowId = $in->getByte();
		$this->selectHotbarSlot = $in->getBool();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putUnsignedVarInt($this->selectedHotbarSlot);
		$out->putByte($this->windowId);
		$out->putBool($this->selectHotbarSlot);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handlePlayerHotbar($this);
	}
}
