<?php

declare(strict_types=1);

namespace pocketmine\event\world;

use pocketmine\world\format\Chunk;
use pocketmine\world\World;

/**
 * Called when a Chunk is loaded
 */
class ChunkLoadEvent extends ChunkEvent{
	/** @var bool */
	private $newChunk;

	public function __construct(World $world, int $chunkX, int $chunkZ, Chunk $chunk, bool $newChunk){
		parent::__construct($world, $chunkX, $chunkZ, $chunk);
		$this->newChunk = $newChunk;
	}

	public function isNewChunk() : bool{
		return $this->newChunk;
	}
}
