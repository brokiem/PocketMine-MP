<?php

declare(strict_types=1);

namespace pocketmine\world\format\io;

use pocketmine\world\format\Chunk;
use pocketmine\world\WorldCreationOptions;

interface WritableWorldProvider extends WorldProvider{
	/**
	 * Generate the needed files in the path given
	 */
	public static function generate(string $path, string $name, WorldCreationOptions $options) : void;

	/**
	 * Saves a chunk (usually to disk).
	 */
	public function saveChunk(int $chunkX, int $chunkZ, Chunk $chunk) : void;
}
