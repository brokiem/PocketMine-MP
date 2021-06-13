<?php

declare(strict_types=1);

namespace pocketmine\world\generator\populator;

use pocketmine\block\BlockLegacyIds;
use pocketmine\block\utils\TreeType;
use pocketmine\utils\Random;
use pocketmine\world\ChunkManager;
use pocketmine\world\generator\object\Tree as ObjectTree;

class Tree extends Populator{
	/** @var int */
	private $randomAmount = 1;
	/** @var int */
	private $baseAmount = 0;

	/** @var TreeType */
	private $type;

	/**
	 * @param TreeType|null $type default oak
	 */
	public function __construct(?TreeType $type = null){
		$this->type = $type ?? TreeType::OAK();
	}

	public function setRandomAmount(int $amount) : void{
		$this->randomAmount = $amount;
	}

	public function setBaseAmount(int $amount) : void{
		$this->baseAmount = $amount;
	}

	public function populate(ChunkManager $world, int $chunkX, int $chunkZ, Random $random) : void{
		$amount = $random->nextRange(0, $this->randomAmount) + $this->baseAmount;
		for($i = 0; $i < $amount; ++$i){
			$x = $random->nextRange($chunkX << 4, ($chunkX << 4) + 15);
			$z = $random->nextRange($chunkZ << 4, ($chunkZ << 4) + 15);
			$y = $this->getHighestWorkableBlock($world, $x, $z);
			if($y === -1){
				continue;
			}
			ObjectTree::growTree($world, $x, $y, $z, $random, $this->type);
		}
	}

	private function getHighestWorkableBlock(ChunkManager $world, int $x, int $z) : int{
		for($y = 127; $y >= 0; --$y){
			$b = $world->getBlockAt($x, $y, $z)->getId();
			if($b === BlockLegacyIds::DIRT or $b === BlockLegacyIds::GRASS){
				return $y + 1;
			}elseif($b !== BlockLegacyIds::AIR and $b !== BlockLegacyIds::SNOW_LAYER){
				return -1;
			}
		}

		return -1;
	}
}
