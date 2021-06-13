<?php

declare(strict_types=1);

namespace pocketmine\world\format\io\region;

use pocketmine\world\format\Chunk;
use pocketmine\world\format\io\data\JavaWorldData;
use pocketmine\world\format\io\WritableWorldProvider;
use pocketmine\world\WorldCreationOptions;
use function file_exists;
use function mkdir;

/**
 * This class implements the stuff needed for general region-based world providers to support saving.
 * While this isn't used at the time of writing, it may come in useful if Java 1.13 Anvil support is ever implemented,
 * or for a custom world format based on the region concept.
 */
abstract class WritableRegionWorldProvider extends RegionWorldProvider implements WritableWorldProvider{

	public static function generate(string $path, string $name, WorldCreationOptions $options) : void{
		if(!file_exists($path)){
			mkdir($path, 0777, true);
		}

		if(!file_exists($path . "/region")){
			mkdir($path . "/region", 0777);
		}

		JavaWorldData::generate($path, $name, $options, static::getPcWorldFormatVersion());
	}

	abstract protected function serializeChunk(Chunk $chunk) : string;

	public function saveChunk(int $chunkX, int $chunkZ, Chunk $chunk) : void{
		self::getRegionIndex($chunkX, $chunkZ, $regionX, $regionZ);
		$this->loadRegion($regionX, $regionZ)->writeChunk($chunkX & 0x1f, $chunkZ & 0x1f, $this->serializeChunk($chunk));
	}
}
