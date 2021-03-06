<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\event\block\BlockGrowEvent;
use pocketmine\item\Item;
use pocketmine\math\Facing;
use function array_rand;
use function mt_rand;

abstract class Stem extends Crops{

	abstract protected function getPlant() : Block;

	public function onRandomTick() : void{
		if(mt_rand(0, 2) === 1){
			if($this->age < 7){
				$block = clone $this;
				++$block->age;
				$ev = new BlockGrowEvent($this, $block);
				$ev->call();
				if(!$ev->isCancelled()){
					$this->pos->getWorld()->setBlock($this->pos, $ev->getNewState());
				}
			}else{
				$grow = $this->getPlant();
				foreach(Facing::HORIZONTAL as $side){
					if($this->getSide($side)->isSameType($grow)){
						return;
					}
				}

				$side = $this->getSide(Facing::HORIZONTAL[array_rand(Facing::HORIZONTAL)]);
				$d = $side->getSide(Facing::DOWN);
				if($side->getId() === BlockLegacyIds::AIR and ($d->getId() === BlockLegacyIds::FARMLAND or $d->getId() === BlockLegacyIds::GRASS or $d->getId() === BlockLegacyIds::DIRT)){
					$ev = new BlockGrowEvent($side, $grow);
					$ev->call();
					if(!$ev->isCancelled()){
						$this->pos->getWorld()->setBlock($side->pos, $ev->getNewState());
					}
				}
			}
		}
	}

	public function getDropsForCompatibleTool(Item $item) : array{
		return [
			$this->asItem()->setCount(mt_rand(0, 2))
		];
	}
}
