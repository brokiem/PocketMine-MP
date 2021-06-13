<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types\inventory;

use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\InventoryTransactionPacket;
use pocketmine\network\mcpe\protocol\ProtocolInfo;
use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class UseItemOnEntityTransactionData extends TransactionData{
	public const ACTION_INTERACT = 0;
	public const ACTION_ATTACK = 1;
	public const ACTION_ITEM_INTERACT = 2;

	/** @var int */
	private $entityRuntimeId;
	/** @var int */
	private $actionType;
	/** @var int */
	private $hotbarSlot;
	/** @var ItemStackWrapper */
	private $itemInHand;
	/** @var Vector3 */
	private $playerPos;
	/** @var Vector3 */
	private $clickPos;

	public function getEntityRuntimeId() : int{
		return $this->entityRuntimeId;
	}

	public function getActionType() : int{
		return $this->actionType;
	}

	public function getHotbarSlot() : int{
		return $this->hotbarSlot;
	}

	public function getItemInHand() : ItemStackWrapper{
		return $this->itemInHand;
	}

	public function getPlayerPos() : Vector3{
		return $this->playerPos;
	}

	public function getClickPos() : Vector3{
		return $this->clickPos;
	}

	public function getTypeId() : int{
		return InventoryTransactionPacket::TYPE_USE_ITEM_ON_ENTITY;
	}

	protected function decodeData(PacketSerializer $stream) : void{
		$this->entityRuntimeId = $stream->getEntityRuntimeId();
		$this->actionType = $stream->getUnsignedVarInt();
		$this->hotbarSlot = $stream->getVarInt();
		if($stream->getProtocolId() >= ProtocolInfo::PROTOCOL_1_16_220){
			$this->itemInHand = ItemStackWrapper::read($stream);
		}else{
			$this->itemInHand = ItemStackWrapper::legacy($stream->getItemStackWithoutStackId());
		}
		$this->playerPos = $stream->getVector3();
		$this->clickPos = $stream->getVector3();
	}

	protected function encodeData(PacketSerializer $stream) : void{
		$stream->putEntityRuntimeId($this->entityRuntimeId);
		$stream->putUnsignedVarInt($this->actionType);
		$stream->putVarInt($this->hotbarSlot);
		if($stream->getProtocolId() >= ProtocolInfo::PROTOCOL_1_16_220){
			$this->itemInHand->write($stream);
		}else{
			$stream->putItemStackWithoutStackId($this->itemInHand->getItemStack());
		}
		$stream->putVector3($this->playerPos);
		$stream->putVector3($this->clickPos);
	}

	/**
	 * @param NetworkInventoryAction[] $actions
	 */
	public static function new(array $actions, int $entityRuntimeId, int $actionType, int $hotbarSlot, ItemStackWrapper $itemInHand, Vector3 $playerPos, Vector3 $clickPos) : self{
		$result = new self;
		$result->actions = $actions;
		$result->entityRuntimeId = $entityRuntimeId;
		$result->actionType = $actionType;
		$result->hotbarSlot = $hotbarSlot;
		$result->itemInHand = $itemInHand;
		$result->playerPos = $playerPos;
		$result->clickPos = $clickPos;
		return $result;
	}
}
