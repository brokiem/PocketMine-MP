<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types\inventory\stackrequest;

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

/**
 * Tells that the current transaction involves crafting an item in a way that isn't supported by the current system.
 * At the time of writing, this includes using anvils.
 */
final class DeprecatedCraftingNonImplementedStackRequestAction extends ItemStackRequestAction{

	public static function getTypeId() : int{
		return ItemStackRequestActionType::CRAFTING_NON_IMPLEMENTED_DEPRECATED_ASK_TY_LAING;
	}

	public static function read(PacketSerializer $in) : self{
		return new self;
	}

	public function write(PacketSerializer $out) : void{
		//NOOP
	}
}
