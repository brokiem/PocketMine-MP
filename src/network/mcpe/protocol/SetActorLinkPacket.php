<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;
use pocketmine\network\mcpe\protocol\types\entity\EntityLink;

class SetActorLinkPacket extends DataPacket implements ClientboundPacket{
	public const NETWORK_ID = ProtocolInfo::SET_ACTOR_LINK_PACKET;

	/** @var EntityLink */
	public $link;

	protected function decodePayload(PacketSerializer $in) : void{
		$this->link = $in->getEntityLink();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putEntityLink($this->link);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleSetActorLink($this);
	}
}
