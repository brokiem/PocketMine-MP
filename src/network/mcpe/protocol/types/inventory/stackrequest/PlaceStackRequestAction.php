<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types\inventory\stackrequest;

/**
 * Puts some (or all) of the items from the source slot into the destination slot.
 */
final class PlaceStackRequestAction extends ItemStackRequestAction{
	use TakeOrPlaceStackRequestActionTrait;

	public static function getTypeId() : int{ return ItemStackRequestActionType::PLACE; }
}
