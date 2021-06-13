<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types\inventory;

use pocketmine\network\mcpe\protocol\InventoryTransactionPacket;
use pocketmine\network\mcpe\protocol\PacketDecodeException;
use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;
use function count;

class MismatchTransactionData extends TransactionData{

	public function getTypeId() : int{
		return InventoryTransactionPacket::TYPE_MISMATCH;
	}

	protected function decodeData(PacketSerializer $stream) : void{
		if(count($this->actions) > 0){
			throw new PacketDecodeException("Mismatch transaction type should not have any actions associated with it, but got " . count($this->actions));
		}
	}

	protected function encodeData(PacketSerializer $stream) : void{

	}

	public static function new() : self{
		return new self; //no arguments
	}
}
