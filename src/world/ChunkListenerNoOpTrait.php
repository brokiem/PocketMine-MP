<?php

declare(strict_types=1);

namespace pocketmine\world;

use pocketmine\math\Vector3;
use pocketmine\world\format\Chunk;

/**
 * This trait implements no-op default methods for chunk listeners.
 * @see ChunkListener
 */
trait ChunkListenerNoOpTrait/* implements ChunkListener*/{

	public function onChunkChanged(int $chunkX, int $chunkZ, Chunk $chunk) : void{
		//NOOP
	}

	public function onChunkLoaded(int $chunkX, int $chunkZ, Chunk $chunk) : void{
		//NOOP
	}

	public function onChunkUnloaded(int $chunkX, int $chunkZ, Chunk $chunk) : void{
		//NOOP
	}

	public function onChunkPopulated(int $chunkX, int $chunkZ, Chunk $chunk) : void{
		//NOOP
	}

	public function onBlockChanged(Vector3 $block) : void{
		//NOOP
	}
}
