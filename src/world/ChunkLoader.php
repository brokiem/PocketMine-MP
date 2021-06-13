<?php

declare(strict_types=1);

namespace pocketmine\world;

/**
 * If you want to keep chunks loaded, implement this interface and register it into World.
 *
 * @see World::registerChunkLoader()
 * @see World::unregisterChunkLoader()
 *
 * WARNING: When moving this object around in the world or destroying it,
 * be sure to unregister the loader from chunks you're not using, otherwise you'll leak memory.
 */
interface ChunkLoader{

}
