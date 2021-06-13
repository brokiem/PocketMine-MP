<?php

declare(strict_types=1);

namespace pocketmine\event\world;

use pocketmine\event\Cancellable;
use pocketmine\event\CancellableTrait;

/**
 * Called when a World is unloaded
 */
class WorldUnloadEvent extends WorldEvent implements Cancellable{
	use CancellableTrait;
}
