<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types\inventory\stackrequest;

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

/**
 * I have no clear idea what this does. It seems to be the client hinting to the server "hey, put a secondary output in
 * X crafting grid slot". This is used for things like buckets.
 */
final class CraftingMarkSecondaryResultStackRequestAction extends ItemStackRequestAction{

	/** @var int */
	private $craftingGridSlot;

	public function __construct(int $craftingGridSlot){
		$this->craftingGridSlot = $craftingGridSlot;
	}

	public function getCraftingGridSlot() : int{ return $this->craftingGridSlot; }

	public static function getTypeId() : int{ return ItemStackRequestActionType::CRAFTING_MARK_SECONDARY_RESULT_SLOT; }

	public static function read(PacketSerializer $in) : self{
		$slot = $in->getByte();
		return new self($slot);
	}

	public function write(PacketSerializer $out) : void{
		$out->putByte($this->craftingGridSlot);
	}
}
