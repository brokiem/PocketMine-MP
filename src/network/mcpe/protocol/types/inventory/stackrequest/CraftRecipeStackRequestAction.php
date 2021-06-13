<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types\inventory\stackrequest;

/**
 * Tells that the current transaction crafted the specified recipe.
 */
final class CraftRecipeStackRequestAction extends ItemStackRequestAction{
	use CraftRecipeStackRequestActionTrait;

	public static function getTypeId() : int{ return ItemStackRequestActionType::CRAFTING_RECIPE; }
}
