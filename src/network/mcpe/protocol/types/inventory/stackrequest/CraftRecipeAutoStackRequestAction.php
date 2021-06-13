<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types\inventory\stackrequest;

/**
 * Tells that the current transaction crafted the specified recipe, using the recipe book. This is effectively the same
 * as the regular crafting result action.
 */
final class CraftRecipeAutoStackRequestAction extends ItemStackRequestAction{
	use CraftRecipeStackRequestActionTrait;

	public static function getTypeId() : int{ return ItemStackRequestActionType::CRAFTING_RECIPE_AUTO; }
}
