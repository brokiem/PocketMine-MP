<?php

declare(strict_types=1);

namespace pocketmine\event\block;

use pocketmine\event\Cancellable;

/**
 * Called when plants or crops grow.
 */
class BlockGrowEvent extends BaseBlockChangeEvent implements Cancellable{

}
