<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types\inventory;

use pocketmine\network\mcpe\protocol\InventoryTransactionPacket;
use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class NormalTransactionData extends TransactionData{

	public function getTypeId() : int{
		return InventoryTransactionPacket::TYPE_NORMAL;
	}

	protected function decodeData(PacketSerializer $stream) : void{

	}

	protected function encodeData(PacketSerializer $stream) : void{

	}

	/**
	 * @param NetworkInventoryAction[] $actions
	 *
	 * @return NormalTransactionData
	 */
	public static function new(array $actions) : self{
		$result = new self();
		$result->actions = $actions;
		return $result;
	}
}
