<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types\inventory\stackrequest;

/**
 * Sends some (or all) items from the source slot to /dev/null. This happens when the player clicks items into the
 * creative inventory menu in creative mode.
 */
final class DestroyStackRequestAction extends ItemStackRequestAction{
	use DisappearStackRequestActionTrait;

	public static function getTypeId() : int{ return ItemStackRequestActionType::DESTROY; }
}
