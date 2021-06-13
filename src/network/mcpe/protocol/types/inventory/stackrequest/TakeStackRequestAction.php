<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types\inventory\stackrequest;

/**
 * Takes some (or all) of the items from the source slot into the destination slot (usually the cursor?).
 */
final class TakeStackRequestAction extends ItemStackRequestAction{
	use TakeOrPlaceStackRequestActionTrait;

	public static function getTypeId() : int{ return ItemStackRequestActionType::TAKE; }
}
