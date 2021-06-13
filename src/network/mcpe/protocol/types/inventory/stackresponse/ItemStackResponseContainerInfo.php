<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types\inventory\stackresponse;

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;
use function count;

final class ItemStackResponseContainerInfo{

	/** @var int */
	private $containerId;
	/** @var ItemStackResponseSlotInfo[] */
	private $slots;

	/**
	 * @param ItemStackResponseSlotInfo[] $slots
	 */
	public function __construct(int $containerId, array $slots){
		$this->containerId = $containerId;
		$this->slots = $slots;
	}

	public function getContainerId() : int{ return $this->containerId; }

	/** @return ItemStackResponseSlotInfo[] */
	public function getSlots() : array{ return $this->slots; }

	public static function read(PacketSerializer $in) : self{
		$containerId = $in->getByte();
		$slots = [];
		for($i = 0, $len = $in->getUnsignedVarInt(); $i < $len; ++$i){
			$slots[] = ItemStackResponseSlotInfo::read($in);
		}
		return new self($containerId, $slots);
	}

	public function write(PacketSerializer $out) : void{
		$out->putByte($this->containerId);
		$out->putUnsignedVarInt(count($this->slots));
		foreach($this->slots as $slot){
			$slot->write($out);
		}
	}
}
