<?php

declare(strict_types=1);

namespace pocketmine\event\block;

use pocketmine\event\Cancellable;
use pocketmine\event\CancellableTrait;

/**
 * Called when leaves decay due to not being attached to wood.
 */
class LeavesDecayEvent extends BlockEvent implements Cancellable{
	use CancellableTrait;
}
