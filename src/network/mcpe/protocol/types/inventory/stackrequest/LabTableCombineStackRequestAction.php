<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types\inventory\stackrequest;

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

/**
 * Not clear what the point of this is. It's sent when the player uses a lab table, but it's not clear why this action
 * is needed.
 */
final class LabTableCombineStackRequestAction extends ItemStackRequestAction{

	public static function getTypeId() : int{ return ItemStackRequestActionType::LAB_TABLE_COMBINE; }

	public static function read(PacketSerializer $in) : self{
		return new self;
	}

	public function write(PacketSerializer $out) : void{
		//NOOP
	}
}
