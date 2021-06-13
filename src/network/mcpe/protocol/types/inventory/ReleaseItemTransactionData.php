<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types\inventory;

use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\InventoryTransactionPacket;
use pocketmine\network\mcpe\protocol\ProtocolInfo;
use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class ReleaseItemTransactionData extends TransactionData{
	public const ACTION_RELEASE = 0; //bow shoot
	public const ACTION_CONSUME = 1; //eat food, drink potion

	/** @var int */
	private $actionType;
	/** @var int */
	private $hotbarSlot;
	/** @var ItemStackWrapper */
	private $itemInHand;
	/** @var Vector3 */
	private $headPos;

	public function getActionType() : int{
		return $this->actionType;
	}

	public function getHotbarSlot() : int{
		return $this->hotbarSlot;
	}

	public function getItemInHand() : ItemStackWrapper{
		return $this->itemInHand;
	}

	public function getHeadPos() : Vector3{
		return $this->headPos;
	}

	public function getTypeId() : int{
		return InventoryTransactionPacket::TYPE_RELEASE_ITEM;
	}

	protected function decodeData(PacketSerializer $stream) : void{
		$this->actionType = $stream->getUnsignedVarInt();
		$this->hotbarSlot = $stream->getVarInt();
		if($stream->getProtocolId() >= ProtocolInfo::PROTOCOL_1_16_220){
			$this->itemInHand = ItemStackWrapper::read($stream);
		}else{
			$this->itemInHand = ItemStackWrapper::legacy($stream->getItemStackWithoutStackId());
		}
		$this->headPos = $stream->getVector3();
	}

	protected function encodeData(PacketSerializer $stream) : void{
		$stream->putUnsignedVarInt($this->actionType);
		$stream->putVarInt($this->hotbarSlot);
		if($stream->getProtocolId() >= ProtocolInfo::PROTOCOL_1_16_220){
			$this->itemInHand->write($stream);
		}else{
			$stream->putItemStackWithoutStackId($this->itemInHand->getItemStack());
		}
		$stream->putVector3($this->headPos);
	}

	/**
	 * @param NetworkInventoryAction[] $actions
	 */
	public static function new(array $actions, int $actionType, int $hotbarSlot, ItemStackWrapper $itemInHand, Vector3 $headPos) : self{
		$result = new self;
		$result->actions = $actions;
		$result->actionType = $actionType;
		$result->hotbarSlot = $hotbarSlot;
		$result->itemInHand = $itemInHand;
		$result->headPos = $headPos;

		return $result;
	}
}
