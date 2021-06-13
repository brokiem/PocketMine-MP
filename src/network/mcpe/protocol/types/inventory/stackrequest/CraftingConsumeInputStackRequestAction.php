<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types\inventory\stackrequest;

/**
 * Sends some (or all) items from the source slot to the magic place where crafting ingredients turn into result items.
 */
final class CraftingConsumeInputStackRequestAction extends ItemStackRequestAction{
	use DisappearStackRequestActionTrait;

	public static function getTypeId() : int{ return ItemStackRequestActionType::CRAFTING_CONSUME_INPUT; }
}
