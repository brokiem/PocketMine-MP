<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types\inventory;

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;
use function count;

final class InventoryTransactionChangedSlotsHack{

	/** @var int */
	private $containerId;
	/** @var int[] */
	private $changedSlotIndexes;

	/**
	 * @param int[] $changedSlotIndexes
	 */
	public function __construct(int $containerId, array $changedSlotIndexes){
		$this->containerId = $containerId;
		$this->changedSlotIndexes = $changedSlotIndexes;
	}

	public function getContainerId() : int{ return $this->containerId; }

	/** @return int[] */
	public function getChangedSlotIndexes() : array{ return $this->changedSlotIndexes; }

	public static function read(PacketSerializer $in) : self{
		$containerId = $in->getByte();
		$changedSlots = [];
		for($i = 0, $len = $in->getUnsignedVarInt(); $i < $len; ++$i){
			$changedSlots[] = $in->getByte();
		}
		return new self($containerId, $changedSlots);
	}

	public function write(PacketSerializer $out) : void{
		$out->putByte($this->containerId);
		$out->putUnsignedVarInt(count($this->changedSlotIndexes));
		foreach($this->changedSlotIndexes as $index){
			$out->putByte($index);
		}
	}
}
