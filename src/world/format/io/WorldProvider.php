<?php

declare(strict_types=1);

namespace pocketmine\world\format\io;

use pocketmine\world\format\Chunk;
use pocketmine\world\format\io\exception\CorruptedChunkException;
use pocketmine\world\format\io\exception\CorruptedWorldException;
use pocketmine\world\format\io\exception\UnsupportedWorldFormatException;

interface WorldProvider{

	/**
	 * @throws CorruptedWorldException
	 * @throws UnsupportedWorldFormatException
	 */
	public function __construct(string $path);

	/**
	 * Returns the lowest buildable Y coordinate of this world
	 */
	public function getWorldMinY() : int;

	/**
	 * Gets the build height limit of this world
	 */
	public function getWorldMaxY() : int;

	public function getPath() : string;

	/**
	 * Tells if the path is a valid world.
	 * This must tell if the current format supports opening the files in the directory
	 */
	public static function isValid(string $path) : bool;

	/**
	 * Loads a chunk (usually from disk storage) and returns it. If the chunk does not exist, null is returned.
	 *
	 * @throws CorruptedChunkException
	 */
	public function loadChunk(int $chunkX, int $chunkZ) : ?Chunk;

	/**
	 * Performs garbage collection in the world provider, such as cleaning up regions in Region-based worlds.
	 */
	public function doGarbageCollection() : void;

	/**
	 * Returns information about the world
	 */
	public function getWorldData() : WorldData;

	/**
	 * Performs cleanups necessary when the world provider is closed and no longer needed.
	 */
	public function close() : void;

	/**
	 * Returns a generator which yields all the chunks in this world.
	 *
	 * @return \Generator|Chunk[]
	 * @phpstan-return \Generator<array{int, int}, Chunk, void, void>
	 * @throws CorruptedChunkException
	 */
	public function getAllChunks(bool $skipCorrupted = false, ?\Logger $logger = null) : \Generator;

	/**
	 * Returns the number of chunks in the provider. Used for world conversion time estimations.
	 */
	public function calculateChunkCount() : int;
}
