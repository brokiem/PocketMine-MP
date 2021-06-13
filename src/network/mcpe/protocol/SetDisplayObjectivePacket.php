<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class SetDisplayObjectivePacket extends DataPacket implements ClientboundPacket{
	public const NETWORK_ID = ProtocolInfo::SET_DISPLAY_OBJECTIVE_PACKET;

	public const DISPLAY_SLOT_LIST = "list";
	public const DISPLAY_SLOT_SIDEBAR = "sidebar";
	public const DISPLAY_SLOT_BELOW_NAME = "belowname";

	public const SORT_ORDER_ASCENDING = 0;
	public const SORT_ORDER_DESCENDING = 1;

	/** @var string */
	public $displaySlot;
	/** @var string */
	public $objectiveName;
	/** @var string */
	public $displayName;
	/** @var string */
	public $criteriaName;
	/** @var int */
	public $sortOrder;

	protected function decodePayload(PacketSerializer $in) : void{
		$this->displaySlot = $in->getString();
		$this->objectiveName = $in->getString();
		$this->displayName = $in->getString();
		$this->criteriaName = $in->getString();
		$this->sortOrder = $in->getVarInt();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putString($this->displaySlot);
		$out->putString($this->objectiveName);
		$out->putString($this->displayName);
		$out->putString($this->criteriaName);
		$out->putVarInt($this->sortOrder);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleSetDisplayObjective($this);
	}
}
