<?php

declare(strict_types=1);

namespace pocketmine\world\biome;

use pocketmine\block\utils\TreeType;
use pocketmine\data\bedrock\BiomeIds;
use pocketmine\utils\SingletonTrait;

final class BiomeRegistry{
	use SingletonTrait;

	/**
	 * @var Biome[]|\SplFixedArray
	 * @phpstan-var \SplFixedArray<Biome>
	 */
	private $biomes;

	public function __construct(){
		$this->biomes = new \SplFixedArray(Biome::MAX_BIOMES);

		$this->register(BiomeIds::OCEAN, new OceanBiome());
		$this->register(BiomeIds::PLAINS, new PlainBiome());
		$this->register(BiomeIds::DESERT, new DesertBiome());
		$this->register(BiomeIds::MOUNTAINS, new MountainsBiome());
		$this->register(BiomeIds::FOREST, new ForestBiome());
		$this->register(BiomeIds::TAIGA, new TaigaBiome());
		$this->register(BiomeIds::SWAMP, new SwampBiome());
		$this->register(BiomeIds::RIVER, new RiverBiome());

		$this->register(BiomeIds::HELL, new HellBiome());

		$this->register(BiomeIds::ICE_PLAINS, new IcePlainsBiome());

		$this->register(BiomeIds::SMALL_MOUNTAINS, new SmallMountainsBiome());

		$this->register(BiomeIds::BIRCH_FOREST, new ForestBiome(TreeType::BIRCH()));
	}

	public function register(int $id, Biome $biome) : void{
		$this->biomes[$id] = $biome;
		$biome->setId($id);
	}

	public function getBiome(int $id) : Biome{
		if($this->biomes[$id] === null){
			$this->register($id, new UnknownBiome());
		}

		return $this->biomes[$id];
	}
}
