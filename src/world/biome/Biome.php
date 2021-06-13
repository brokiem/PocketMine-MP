<?php

declare(strict_types=1);

namespace pocketmine\world\biome;

use pocketmine\block\Block;
use pocketmine\utils\Random;
use pocketmine\world\ChunkManager;
use pocketmine\world\generator\populator\Populator;

abstract class Biome{

	public const MAX_BIOMES = 256;

	/** @var int */
	private $id;
	/** @var bool */
	private $registered = false;

	/** @var Populator[] */
	private $populators = [];

	/** @var int */
	private $minElevation;
	/** @var int */
	private $maxElevation;

	/** @var Block[] */
	private $groundCover = [];

	/** @var float */
	protected $rainfall = 0.5;
	/** @var float */
	protected $temperature = 0.5;

	public function clearPopulators() : void{
		$this->populators = [];
	}

	public function addPopulator(Populator $populator) : void{
		$this->populators[] = $populator;
	}

	public function populateChunk(ChunkManager $world, int $chunkX, int $chunkZ, Random $random) : void{
		foreach($this->populators as $populator){
			$populator->populate($world, $chunkX, $chunkZ, $random);
		}
	}

	/**
	 * @return Populator[]
	 */
	public function getPopulators() : array{
		return $this->populators;
	}

	public function setId(int $id) : void{
		if(!$this->registered){
			$this->registered = true;
			$this->id = $id;
		}
	}

	public function getId() : int{
		return $this->id;
	}

	abstract public function getName() : string;

	public function getMinElevation() : int{
		return $this->minElevation;
	}

	public function getMaxElevation() : int{
		return $this->maxElevation;
	}

	public function setElevation(int $min, int $max) : void{
		$this->minElevation = $min;
		$this->maxElevation = $max;
	}

	/**
	 * @return Block[]
	 */
	public function getGroundCover() : array{
		return $this->groundCover;
	}

	/**
	 * @param Block[] $covers
	 */
	public function setGroundCover(array $covers) : void{
		$this->groundCover = $covers;
	}

	public function getTemperature() : float{
		return $this->temperature;
	}

	public function getRainfall() : float{
		return $this->rainfall;
	}
}
