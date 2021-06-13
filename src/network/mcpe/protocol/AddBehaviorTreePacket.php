<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class AddBehaviorTreePacket extends DataPacket implements ClientboundPacket{
	public const NETWORK_ID = ProtocolInfo::ADD_BEHAVIOR_TREE_PACKET;

	/** @var string */
	public $behaviorTreeJson;

	protected function decodePayload(PacketSerializer $in) : void{
		$this->behaviorTreeJson = $in->getString();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putString($this->behaviorTreeJson);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleAddBehaviorTree($this);
	}
}
