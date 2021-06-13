<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types\inventory\stackresponse;

use pocketmine\network\mcpe\protocol\ProtocolInfo;
use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

final class ItemStackResponseSlotInfo{

	/** @var int */
	private $slot;
	/** @var int */
	private $hotbarSlot;
	/** @var int */
	private $count;
	/** @var int */
	private $itemStackId;
	/** @var string */
	private $customName;
	/** @var int */
	private $durabilityCorrection;

	public function __construct(int $slot, int $hotbarSlot, int $count, int $itemStackId, string $customName, int $durabilityCorrection){
		$this->slot = $slot;
		$this->hotbarSlot = $hotbarSlot;
		$this->count = $count;
		$this->itemStackId = $itemStackId;
		$this->customName = $customName;
		$this->durabilityCorrection = $durabilityCorrection;
	}

	public function getSlot() : int{ return $this->slot; }

	public function getHotbarSlot() : int{ return $this->hotbarSlot; }

	public function getCount() : int{ return $this->count; }

	public function getItemStackId() : int{ return $this->itemStackId; }

	public function getCustomName() : string{ return $this->customName; }

	public function getDurabilityCorrection() : int{ return $this->durabilityCorrection; }

	public static function read(PacketSerializer $in) : self{
		$slot = $in->getByte();
		$hotbarSlot = $in->getByte();
		$count = $in->getByte();
		$itemStackId = $in->readGenericTypeNetworkId();
		if($in->getProtocolId() >= ProtocolInfo::PROTOCOL_1_16_200){
			$customName = $in->getString();
			if($in->getProtocolId() >= ProtocolInfo::PROTOCOL_1_16_210_57){
				$durabilityCorrection = $in->getVarInt();
			}
		}
		return new self($slot, $hotbarSlot, $count, $itemStackId, $customName ?? '', $durabilityCorrection ?? 0);
	}

	public function write(PacketSerializer $out) : void{
		$out->putByte($this->slot);
		$out->putByte($this->hotbarSlot);
		$out->putByte($this->count);
		$out->writeGenericTypeNetworkId($this->itemStackId);
		if($out->getProtocolId() >= ProtocolInfo::PROTOCOL_1_16_200){
			$out->putString($this->customName);
			if($out->getProtocolId() >= ProtocolInfo::PROTOCOL_1_16_210_57){
				$out->putVarInt($this->durabilityCorrection);
			}
		}
	}
}
