<?php

declare(strict_types=1);

namespace pocketmine\world\generator\normal;

use pocketmine\block\VanillaBlocks;
use pocketmine\data\bedrock\BiomeIds;
use pocketmine\world\biome\Biome;
use pocketmine\world\biome\BiomeRegistry;
use pocketmine\world\ChunkManager;
use pocketmine\world\generator\biome\BiomeSelector;
use pocketmine\world\generator\Gaussian;
use pocketmine\world\generator\Generator;
use pocketmine\world\generator\InvalidGeneratorOptionsException;
use pocketmine\world\generator\noise\Simplex;
use pocketmine\world\generator\object\OreType;
use pocketmine\world\generator\populator\GroundCover;
use pocketmine\world\generator\populator\Ore;
use pocketmine\world\generator\populator\Populator;
use pocketmine\world\World;

class Normal extends Generator{

	/** @var Populator[] */
	private $populators = [];
	/** @var int */
	private $waterHeight = 62;

	/** @var Populator[] */
	private $generationPopulators = [];
	/** @var Simplex */
	private $noiseBase;

	/** @var BiomeSelector */
	private $selector;

	/** @var Gaussian */
	private $gaussian;

	/**
	 * @throws InvalidGeneratorOptionsException
	 */
	public function __construct(int $seed, string $preset){
		parent::__construct($seed, $preset);

		$this->gaussian = new Gaussian(2);

		$this->noiseBase = new Simplex($this->random, 4, 1 / 4, 1 / 32);
		$this->random->setSeed($this->seed);

		$this->selector = new class($this->random) extends BiomeSelector{
			protected function lookup(float $temperature, float $rainfall) : int{
				if($rainfall < 0.25){
					if($temperature < 0.7){
						return BiomeIds::OCEAN;
					}elseif($temperature < 0.85){
						return BiomeIds::RIVER;
					}else{
						return BiomeIds::SWAMP;
					}
				}elseif($rainfall < 0.60){
					if($temperature < 0.25){
						return BiomeIds::ICE_PLAINS;
					}elseif($temperature < 0.75){
						return BiomeIds::PLAINS;
					}else{
						return BiomeIds::DESERT;
					}
				}elseif($rainfall < 0.80){
					if($temperature < 0.25){
						return BiomeIds::TAIGA;
					}elseif($temperature < 0.75){
						return BiomeIds::FOREST;
					}else{
						return BiomeIds::BIRCH_FOREST;
					}
				}else{
					if($temperature < 0.20){
						return BiomeIds::MOUNTAINS;
					}elseif($temperature < 0.40){
						return BiomeIds::SMALL_MOUNTAINS;
					}else{
						return BiomeIds::RIVER;
					}
				}
			}
		};

		$this->selector->recalculate();

		$cover = new GroundCover();
		$this->generationPopulators[] = $cover;

		$ores = new Ore();
		$stone = VanillaBlocks::STONE();
		$ores->setOreTypes([
			new OreType(VanillaBlocks::COAL_ORE(), $stone, 20, 16, 0, 128),
			new OreType(VanillaBlocks::IRON_ORE(), $stone, 20, 8, 0, 64),
			new OreType(VanillaBlocks::REDSTONE_ORE(), $stone, 8, 7, 0, 16),
			new OreType(VanillaBlocks::LAPIS_LAZULI_ORE(), $stone, 1, 6, 0, 32),
			new OreType(VanillaBlocks::GOLD_ORE(), $stone, 2, 8, 0, 32),
			new OreType(VanillaBlocks::DIAMOND_ORE(), $stone, 1, 7, 0, 16),
			new OreType(VanillaBlocks::DIRT(), $stone, 20, 32, 0, 128),
			new OreType(VanillaBlocks::GRAVEL(), $stone, 10, 16, 0, 128)
		]);
		$this->populators[] = $ores;
	}

	private function pickBiome(int $x, int $z) : Biome{
		$hash = $x * 2345803 ^ $z * 9236449 ^ $this->seed;
		$hash *= $hash + 223;
		$xNoise = $hash >> 20 & 3;
		$zNoise = $hash >> 22 & 3;
		if($xNoise == 3){
			$xNoise = 1;
		}
		if($zNoise == 3){
			$zNoise = 1;
		}

		return $this->selector->pickBiome($x + $xNoise - 1, $z + $zNoise - 1);
	}

	public function generateChunk(ChunkManager $world, int $chunkX, int $chunkZ) : void{
		$this->random->setSeed(0xdeadbeef ^ ($chunkX << 8) ^ $chunkZ ^ $this->seed);

		$noise = $this->noiseBase->getFastNoise3D(16, 128, 16, 4, 8, 4, $chunkX * 16, 0, $chunkZ * 16);

		$chunk = $world->getChunk($chunkX, $chunkZ);

		$biomeCache = [];

		$bedrock = VanillaBlocks::BEDROCK()->getFullId();
		$stillWater = VanillaBlocks::WATER()->getFullId();
		$stone = VanillaBlocks::STONE()->getFullId();

		$baseX = $chunkX * 16;
		$baseZ = $chunkZ * 16;
		for($x = 0; $x < 16; ++$x){
			$absoluteX = $baseX + $x;
			for($z = 0; $z < 16; ++$z){
				$absoluteZ = $baseZ + $z;
				$minSum = 0;
				$maxSum = 0;
				$weightSum = 0;

				$biome = $this->pickBiome($absoluteX, $absoluteZ);
				$chunk->setBiomeId($x, $z, $biome->getId());

				for($sx = -$this->gaussian->smoothSize; $sx <= $this->gaussian->smoothSize; ++$sx){
					for($sz = -$this->gaussian->smoothSize; $sz <= $this->gaussian->smoothSize; ++$sz){

						$weight = $this->gaussian->kernel[$sx + $this->gaussian->smoothSize][$sz + $this->gaussian->smoothSize];

						if($sx === 0 and $sz === 0){
							$adjacent = $biome;
						}else{
							$index = World::chunkHash($absoluteX + $sx, $absoluteZ + $sz);
							if(isset($biomeCache[$index])){
								$adjacent = $biomeCache[$index];
							}else{
								$biomeCache[$index] = $adjacent = $this->pickBiome($absoluteX + $sx, $absoluteZ + $sz);
							}
						}

						$minSum += ($adjacent->getMinElevation() - 1) * $weight;
						$maxSum += $adjacent->getMaxElevation() * $weight;

						$weightSum += $weight;
					}
				}

				$minSum /= $weightSum;
				$maxSum /= $weightSum;

				$smoothHeight = ($maxSum - $minSum) / 2;

				for($y = 0; $y < 128; ++$y){
					if($y === 0){
						$chunk->setFullBlock($x, $y, $z, $bedrock);
						continue;
					}
					$noiseValue = $noise[$x][$z][$y] - 1 / $smoothHeight * ($y - $smoothHeight - $minSum);

					if($noiseValue > 0){
						$chunk->setFullBlock($x, $y, $z, $stone);
					}elseif($y <= $this->waterHeight){
						$chunk->setFullBlock($x, $y, $z, $stillWater);
					}
				}
			}
		}

		foreach($this->generationPopulators as $populator){
			$populator->populate($world, $chunkX, $chunkZ, $this->random);
		}
	}

	public function populateChunk(ChunkManager $world, int $chunkX, int $chunkZ) : void{
		$this->random->setSeed(0xdeadbeef ^ ($chunkX << 8) ^ $chunkZ ^ $this->seed);
		foreach($this->populators as $populator){
			$populator->populate($world, $chunkX, $chunkZ, $this->random);
		}

		$chunk = $world->getChunk($chunkX, $chunkZ);
		$biome = BiomeRegistry::getInstance()->getBiome($chunk->getBiomeId(7, 7));
		$biome->populateChunk($world, $chunkX, $chunkZ, $this->random);
	}
}
