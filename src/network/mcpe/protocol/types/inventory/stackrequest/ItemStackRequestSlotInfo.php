<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types\inventory\stackrequest;

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

final class ItemStackRequestSlotInfo{

	/** @var int */
	private $containerId;
	/** @var int */
	private $slotId;
	/** @var int */
	private $stackId;

	public function __construct(int $containerId, int $slotId, int $stackId){
		$this->containerId = $containerId;
		$this->slotId = $slotId;
		$this->stackId = $stackId;
	}

	public function getContainerId() : int{ return $this->containerId; }

	public function getSlotId() : int{ return $this->slotId; }

	public function getStackId() : int{ return $this->stackId; }

	public static function read(PacketSerializer $in) : self{
		$containerId = $in->getByte();
		$slotId = $in->getByte();
		$stackId = $in->readGenericTypeNetworkId();
		return new self($containerId, $slotId, $stackId);
	}

	public function write(PacketSerializer $out) : void{
		$out->putByte($this->containerId);
		$out->putByte($this->slotId);
		$out->writeGenericTypeNetworkId($this->stackId);
	}
}
