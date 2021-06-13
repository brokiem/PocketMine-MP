<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class ShowStoreOfferPacket extends DataPacket implements ClientboundPacket{
	public const NETWORK_ID = ProtocolInfo::SHOW_STORE_OFFER_PACKET;

	/** @var string */
	public $offerId;
	/** @var bool */
	public $showAll;

	protected function decodePayload(PacketSerializer $in) : void{
		$this->offerId = $in->getString();
		$this->showAll = $in->getBool();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putString($this->offerId);
		$out->putBool($this->showAll);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleShowStoreOffer($this);
	}
}
