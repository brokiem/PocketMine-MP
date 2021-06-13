<?php

declare(strict_types=1);

namespace pocketmine\world\biome;

/**
 * Polyfill class for biomes that are unknown to PocketMine-MP
 */
class UnknownBiome extends Biome{

	public function getName() : string{
		return "Unknown";
	}
}
