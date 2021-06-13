<?php

declare(strict_types=1);

namespace pocketmine\event\world;

use pocketmine\world\format\Chunk;
use pocketmine\world\World;

/**
 * Chunk-related events
 */
abstract class ChunkEvent extends WorldEvent{
	/** @var Chunk */
	private $chunk;
	/** @var int */
	private $chunkX;
	/** @var int */
	private $chunkZ;

	public function __construct(World $world, int $chunkX, int $chunkZ, Chunk $chunk){
		parent::__construct($world);
		$this->chunk = $chunk;
		$this->chunkX = $chunkX;
		$this->chunkZ = $chunkZ;
	}

	public function getChunk() : Chunk{
		return $this->chunk;
	}

	public function getChunkX() : int{ return $this->chunkX; }

	public function getChunkZ() : int{ return $this->chunkZ; }
}
