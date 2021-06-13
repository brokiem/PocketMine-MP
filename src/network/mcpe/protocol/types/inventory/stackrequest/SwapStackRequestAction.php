<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types\inventory\stackrequest;

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

/**
 * Swaps two stacks. These don't have to be in the same inventory. This action does not modify the stacks themselves.
 */
final class SwapStackRequestAction extends ItemStackRequestAction{

	/** @var ItemStackRequestSlotInfo */
	private $slot1;
	/** @var ItemStackRequestSlotInfo */
	private $slot2;

	public function __construct(ItemStackRequestSlotInfo $slot1, ItemStackRequestSlotInfo $slot2){
		$this->slot1 = $slot1;
		$this->slot2 = $slot2;
	}

	public function getSlot1() : ItemStackRequestSlotInfo{ return $this->slot1; }

	public function getSlot2() : ItemStackRequestSlotInfo{ return $this->slot2; }

	public static function getTypeId() : int{ return ItemStackRequestActionType::SWAP; }

	public static function read(PacketSerializer $in) : self{
		$slot1 = ItemStackRequestSlotInfo::read($in);
		$slot2 = ItemStackRequestSlotInfo::read($in);
		return new self($slot1, $slot2);
	}

	public function write(PacketSerializer $out) : void{
		$this->slot1->write($out);
		$this->slot2->write($out);
	}
}
