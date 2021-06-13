<?php

declare(strict_types=1);

namespace pocketmine\world;

use pocketmine\block\Block;
use pocketmine\block\BlockFactory;
use pocketmine\block\VanillaBlocks;
use pocketmine\utils\Limits;
use pocketmine\world\format\Chunk;

class SimpleChunkManager implements ChunkManager{

	/** @var Chunk[] */
	protected $chunks = [];

	/** @var int */
	private $minY;
	/** @var int */
	private $maxY;

	public function __construct(int $minY, int $maxY){
		$this->minY = $minY;
		$this->maxY = $maxY;
	}

	public function getBlockAt(int $x, int $y, int $z) : Block{
		if($this->isInWorld($x, $y, $z) && ($chunk = $this->getChunk($x >> 4, $z >> 4)) !== null){
			return BlockFactory::getInstance()->fromFullBlock($chunk->getFullBlock($x & 0xf, $y, $z & 0xf));
		}
		return VanillaBlocks::AIR();
	}

	public function setBlockAt(int $x, int $y, int $z, Block $block) : void{
		if(($chunk = $this->getChunk($x >> 4, $z >> 4)) !== null){
			$chunk->setFullBlock($x & 0xf, $y, $z & 0xf, $block->getFullId());
		}else{
			throw new \InvalidArgumentException("Cannot set block at coordinates x=$x,y=$y,z=$z, terrain is not loaded or out of bounds");
		}
	}

	public function getChunk(int $chunkX, int $chunkZ) : ?Chunk{
		return $this->chunks[World::chunkHash($chunkX, $chunkZ)] ?? null;
	}

	public function setChunk(int $chunkX, int $chunkZ, Chunk $chunk) : void{
		$this->chunks[World::chunkHash($chunkX, $chunkZ)] = $chunk;
	}

	public function cleanChunks() : void{
		$this->chunks = [];
	}

	public function getMinY() : int{
		return $this->minY;
	}

	public function getMaxY() : int{
		return $this->maxY;
	}

	public function isInWorld(int $x, int $y, int $z) : bool{
		return (
			$x <= Limits::INT32_MAX and $x >= Limits::INT32_MIN and
			$y < $this->maxY and $y >= $this->minY and
			$z <= Limits::INT32_MAX and $z >= Limits::INT32_MIN
		);
	}
}
