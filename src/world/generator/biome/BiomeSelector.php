<?php

declare(strict_types=1);

namespace pocketmine\world\generator\biome;

use pocketmine\utils\Random;
use pocketmine\world\biome\Biome;
use pocketmine\world\biome\BiomeRegistry;
use pocketmine\world\biome\UnknownBiome;
use pocketmine\world\generator\noise\Simplex;

abstract class BiomeSelector{
	/** @var Simplex */
	private $temperature;
	/** @var Simplex */
	private $rainfall;

	/**
	 * @var Biome[]|\SplFixedArray
	 * @phpstan-var \SplFixedArray<Biome>
	 */
	private $map = null;

	public function __construct(Random $random){
		$this->temperature = new Simplex($random, 2, 1 / 16, 1 / 512);
		$this->rainfall = new Simplex($random, 2, 1 / 16, 1 / 512);
	}

	/**
	 * Lookup function called by recalculate() to determine the biome to use for this temperature and rainfall.
	 *
	 * @return int biome ID 0-255
	 */
	abstract protected function lookup(float $temperature, float $rainfall) : int;

	public function recalculate() : void{
		$this->map = new \SplFixedArray(64 * 64);

		$biomeRegistry = BiomeRegistry::getInstance();
		for($i = 0; $i < 64; ++$i){
			for($j = 0; $j < 64; ++$j){
				$biome = $biomeRegistry->getBiome($this->lookup($i / 63, $j / 63));
				if($biome instanceof UnknownBiome){
					throw new \RuntimeException("Unknown biome returned by selector with ID " . $biome->getId());
				}
				$this->map[$i + ($j << 6)] = $biome;
			}
		}
	}

	public function getTemperature(float $x, float $z) : float{
		return ($this->temperature->noise2D($x, $z, true) + 1) / 2;
	}

	public function getRainfall(float $x, float $z) : float{
		return ($this->rainfall->noise2D($x, $z, true) + 1) / 2;
	}

	public function pickBiome(float $x, float $z) : Biome{
		$temperature = (int) ($this->getTemperature($x, $z) * 63);
		$rainfall = (int) ($this->getRainfall($x, $z) * 63);

		return $this->map[$temperature + ($rainfall << 6)];
	}
}
