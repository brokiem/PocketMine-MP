<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;
use pocketmine\network\mcpe\protocol\types\inventory\InventoryTransactionChangedSlotsHack;
use pocketmine\network\mcpe\protocol\types\inventory\MismatchTransactionData;
use pocketmine\network\mcpe\protocol\types\inventory\NormalTransactionData;
use pocketmine\network\mcpe\protocol\types\inventory\ReleaseItemTransactionData;
use pocketmine\network\mcpe\protocol\types\inventory\TransactionData;
use pocketmine\network\mcpe\protocol\types\inventory\UseItemOnEntityTransactionData;
use pocketmine\network\mcpe\protocol\types\inventory\UseItemTransactionData;
use function count;

/**
 * This packet effectively crams multiple packets into one.
 */
class InventoryTransactionPacket extends DataPacket implements ClientboundPacket, ServerboundPacket{
	public const NETWORK_ID = ProtocolInfo::INVENTORY_TRANSACTION_PACKET;

	public const TYPE_NORMAL = 0;
	public const TYPE_MISMATCH = 1;
	public const TYPE_USE_ITEM = 2;
	public const TYPE_USE_ITEM_ON_ENTITY = 3;
	public const TYPE_RELEASE_ITEM = 4;

	/** @var int */
	public $requestId;
	/** @var InventoryTransactionChangedSlotsHack[] */
	public $requestChangedSlots;
	/** @var bool */
	public $hasItemStackIds = true;
	/** @var TransactionData */
	public $trData;

	protected function decodePayload(PacketSerializer $in) : void{
		$this->requestId = $in->readGenericTypeNetworkId();
		$this->requestChangedSlots = [];
		if($this->requestId !== 0){
			for($i = 0, $len = $in->getUnsignedVarInt(); $i < $len; ++$i){
				$this->requestChangedSlots[] = InventoryTransactionChangedSlotsHack::read($in);
			}
		}

		$transactionType = $in->getUnsignedVarInt();

		if($in->getProtocolId() < ProtocolInfo::PROTOCOL_1_16_220){
			$this->hasItemStackIds = $in->getBool();
		}

		switch($transactionType){
			case self::TYPE_NORMAL:
				$this->trData = new NormalTransactionData();
				break;
			case self::TYPE_MISMATCH:
				$this->trData = new MismatchTransactionData();
				break;
			case self::TYPE_USE_ITEM:
				$this->trData = new UseItemTransactionData();
				break;
			case self::TYPE_USE_ITEM_ON_ENTITY:
				$this->trData = new UseItemOnEntityTransactionData();
				break;
			case self::TYPE_RELEASE_ITEM:
				$this->trData = new ReleaseItemTransactionData();
				break;
			default:
				throw new PacketDecodeException("Unknown transaction type $transactionType");
		}

		$this->trData->decode($in, $this->hasItemStackIds);
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->writeGenericTypeNetworkId($this->requestId);
		if($this->requestId !== 0){
			$out->putUnsignedVarInt(count($this->requestChangedSlots));
			foreach($this->requestChangedSlots as $changedSlots){
				$changedSlots->write($out);
			}
		}

		$out->putUnsignedVarInt($this->trData->getTypeId());

		if($out->getProtocolId() < ProtocolInfo::PROTOCOL_1_16_220){
			$out->putBool($this->hasItemStackIds);
		}

		$this->trData->encode($out, $this->hasItemStackIds);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleInventoryTransaction($this);
	}
}
