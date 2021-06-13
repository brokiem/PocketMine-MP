<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;
use pocketmine\network\mcpe\protocol\types\inventory\ItemStackWrapper;

class MobArmorEquipmentPacket extends DataPacket implements ClientboundPacket, ServerboundPacket{
	public const NETWORK_ID = ProtocolInfo::MOB_ARMOR_EQUIPMENT_PACKET;

	/** @var int */
	public $entityRuntimeId;

	//this intentionally doesn't use an array because we don't want any implicit dependencies on internal order

	/** @var ItemStackWrapper */
	public $head;
	/** @var ItemStackWrapper */
	public $chest;
	/** @var ItemStackWrapper */
	public $legs;
	/** @var ItemStackWrapper */
	public $feet;

	public static function create(int $entityRuntimeId, ItemStackWrapper $head, ItemStackWrapper $chest, ItemStackWrapper $legs, ItemStackWrapper $feet) : self{
		$result = new self;
		$result->entityRuntimeId = $entityRuntimeId;
		$result->head = $head;
		$result->chest = $chest;
		$result->legs = $legs;
		$result->feet = $feet;

		return $result;
	}

	protected function decodePayload(PacketSerializer $in) : void{
		$this->entityRuntimeId = $in->getEntityRuntimeId();
		if($in->getProtocolId() >= ProtocolInfo::PROTOCOL_1_16_220){
			$this->head = ItemStackWrapper::read($in);
			$this->chest = ItemStackWrapper::read($in);
			$this->legs = ItemStackWrapper::read($in);
			$this->feet = ItemStackWrapper::read($in);
		}else{
			$this->head = ItemStackWrapper::legacy($in->getItemStackWithoutStackId());
			$this->chest = ItemStackWrapper::legacy($in->getItemStackWithoutStackId());
			$this->legs = ItemStackWrapper::legacy($in->getItemStackWithoutStackId());
			$this->feet = ItemStackWrapper::legacy($in->getItemStackWithoutStackId());
		}
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putEntityRuntimeId($this->entityRuntimeId);
		if($out->getProtocolId() >= ProtocolInfo::PROTOCOL_1_16_220){
			$this->head->write($out);
			$this->chest->write($out);
			$this->legs->write($out);
			$this->feet->write($out);
		}else{
			$out->putItemStackWithoutStackId($this->head->getItemStack());
			$out->putItemStackWithoutStackId($this->chest->getItemStack());
			$out->putItemStackWithoutStackId($this->legs->getItemStack());
			$out->putItemStackWithoutStackId($this->feet->getItemStack());
		}
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleMobArmorEquipment($this);
	}
}
