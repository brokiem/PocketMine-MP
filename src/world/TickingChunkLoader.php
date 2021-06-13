<?php

declare(strict_types=1);

namespace pocketmine\world;

/**
 * TickingChunkLoader includes all of the same functionality as ChunkLoader (it can be used in the same way).
 * However, using this version will also cause chunks around the loader's reported coordinates to get random block
 * updates.
 */
interface TickingChunkLoader extends ChunkLoader{

	public function getX() : float;

	public function getZ() : float;
}
