<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types\inventory\stackrequest;

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

/**
 * Creates an item by copying it from the creative inventory. This is treated as a crafting action by vanilla.
 */
final class CreativeCreateStackRequestAction extends ItemStackRequestAction{

	/** @var int */
	private $creativeItemId;

	public function __construct(int $creativeItemId){
		$this->creativeItemId = $creativeItemId;
	}

	public function getCreativeItemId() : int{ return $this->creativeItemId; }

	public static function getTypeId() : int{ return ItemStackRequestActionType::CREATIVE_CREATE; }

	public static function read(PacketSerializer $in) : self{
		$creativeItemId = $in->readGenericTypeNetworkId();
		return new self($creativeItemId);
	}

	public function write(PacketSerializer $out) : void{
		$out->writeGenericTypeNetworkId($this->creativeItemId);
	}
}
