<?php

declare(strict_types=1);

/**
 * Noise classes used in world generation
 */
namespace pocketmine\world\generator;

use pocketmine\utils\Random;
use pocketmine\utils\Utils;
use pocketmine\world\ChunkManager;
use function preg_match;

abstract class Generator{

	/**
	 * Converts a string world seed into an integer for use by the generator.
	 */
	public static function convertSeed(string $seed) : ?int{
		if($seed === ""){ //empty seed should cause a random seed to be selected - can't use 0 here because 0 is a valid seed
			$convertedSeed = null;
		}elseif(preg_match('/^-?\d+$/', $seed) === 1){ //this avoids treating seeds like "404.4" as integer seeds
			$convertedSeed = (int) $seed;
		}else{
			$convertedSeed = Utils::javaStringHash($seed);
		}

		return $convertedSeed;
	}

	/** @var int */
	protected $seed;

	protected string $preset;

	/** @var Random */
	protected $random;

	public function __construct(int $seed, string $preset){
		$this->seed = $seed;
		$this->preset = $preset;
		$this->random = new Random($seed);
	}

	abstract public function generateChunk(ChunkManager $world, int $chunkX, int $chunkZ) : void;

	abstract public function populateChunk(ChunkManager $world, int $chunkX, int $chunkZ) : void;
}
