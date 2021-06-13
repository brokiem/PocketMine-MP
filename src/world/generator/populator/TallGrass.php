<?php

declare(strict_types=1);

namespace pocketmine\world\generator\populator;

use pocketmine\block\BlockLegacyIds;
use pocketmine\block\VanillaBlocks;
use pocketmine\utils\Random;
use pocketmine\world\ChunkManager;

class TallGrass extends Populator{
	/** @var int */
	private $randomAmount = 1;
	/** @var int */
	private $baseAmount = 0;

	public function setRandomAmount(int $amount) : void{
		$this->randomAmount = $amount;
	}

	public function setBaseAmount(int $amount) : void{
		$this->baseAmount = $amount;
	}

	public function populate(ChunkManager $world, int $chunkX, int $chunkZ, Random $random) : void{
		$amount = $random->nextRange(0, $this->randomAmount) + $this->baseAmount;

		$block = VanillaBlocks::TALL_GRASS();
		for($i = 0; $i < $amount; ++$i){
			$x = $random->nextRange($chunkX * 16, $chunkX * 16 + 15);
			$z = $random->nextRange($chunkZ * 16, $chunkZ * 16 + 15);
			$y = $this->getHighestWorkableBlock($world, $x, $z);

			if($y !== -1 and $this->canTallGrassStay($world, $x, $y, $z)){
				$world->setBlockAt($x, $y, $z, $block);
			}
		}
	}

	private function canTallGrassStay(ChunkManager $world, int $x, int $y, int $z) : bool{
		$b = $world->getBlockAt($x, $y, $z)->getId();
		return ($b === BlockLegacyIds::AIR or $b === BlockLegacyIds::SNOW_LAYER) and $world->getBlockAt($x, $y - 1, $z)->getId() === BlockLegacyIds::GRASS;
	}

	private function getHighestWorkableBlock(ChunkManager $world, int $x, int $z) : int{
		for($y = 127; $y >= 0; --$y){
			$b = $world->getBlockAt($x, $y, $z)->getId();
			if($b !== BlockLegacyIds::AIR and $b !== BlockLegacyIds::LEAVES and $b !== BlockLegacyIds::LEAVES2 and $b !== BlockLegacyIds::SNOW_LAYER){
				return $y + 1;
			}
		}

		return -1;
	}
}
