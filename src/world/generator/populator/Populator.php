<?php

declare(strict_types=1);

/**
 * All the Object populator classes
 */
namespace pocketmine\world\generator\populator;

use pocketmine\utils\Random;
use pocketmine\world\ChunkManager;

abstract class Populator{

	abstract public function populate(ChunkManager $world, int $chunkX, int $chunkZ, Random $random) : void;
}
