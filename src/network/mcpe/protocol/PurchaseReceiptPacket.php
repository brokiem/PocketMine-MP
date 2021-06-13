<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;
use function count;

class PurchaseReceiptPacket extends DataPacket implements ServerboundPacket{
	public const NETWORK_ID = ProtocolInfo::PURCHASE_RECEIPT_PACKET;

	/** @var string[] */
	public $entries = [];

	protected function decodePayload(PacketSerializer $in) : void{
		$count = $in->getUnsignedVarInt();
		for($i = 0; $i < $count; ++$i){
			$this->entries[] = $in->getString();
		}
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putUnsignedVarInt(count($this->entries));
		foreach($this->entries as $entry){
			$out->putString($entry);
		}
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handlePurchaseReceipt($this);
	}
}
