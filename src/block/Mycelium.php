<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\event\block\BlockSpreadEvent;
use pocketmine\item\Item;
use pocketmine\math\Facing;
use function mt_rand;

class Mycelium extends Opaque{

	public function getDropsForCompatibleTool(Item $item) : array{
		return [
			VanillaBlocks::DIRT()->asItem()
		];
	}

	public function isAffectedBySilkTouch() : bool{
		return true;
	}

	public function ticksRandomly() : bool{
		return true;
	}

	public function onRandomTick() : void{
		//TODO: light levels
		$x = mt_rand($this->pos->x - 1, $this->pos->x + 1);
		$y = mt_rand($this->pos->y - 2, $this->pos->y + 2);
		$z = mt_rand($this->pos->z - 1, $this->pos->z + 1);
		$block = $this->pos->getWorld()->getBlockAt($x, $y, $z);
		if($block->getId() === BlockLegacyIds::DIRT){
			if($block->getSide(Facing::UP) instanceof Transparent){
				$ev = new BlockSpreadEvent($block, $this, VanillaBlocks::MYCELIUM());
				$ev->call();
				if(!$ev->isCancelled()){
					$this->pos->getWorld()->setBlock($block->pos, $ev->getNewState());
				}
			}
		}
	}
}
