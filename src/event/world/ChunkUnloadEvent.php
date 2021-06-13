<?php

declare(strict_types=1);

namespace pocketmine\event\world;

use pocketmine\event\Cancellable;
use pocketmine\event\CancellableTrait;

/**
 * Called when a Chunk is unloaded
 */
class ChunkUnloadEvent extends ChunkEvent implements Cancellable{
	use CancellableTrait;
}
