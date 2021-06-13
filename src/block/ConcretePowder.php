<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\block\utils\ColorInMetadataTrait;
use pocketmine\block\utils\DyeColor;
use pocketmine\block\utils\Fallable;
use pocketmine\block\utils\FallableTrait;
use pocketmine\math\Facing;

class ConcretePowder extends Opaque implements Fallable{
	use ColorInMetadataTrait;
	use FallableTrait {
		onNearbyBlockChange as protected startFalling;
	}

	public function __construct(BlockIdentifier $idInfo, string $name, BlockBreakInfo $breakInfo){
		$this->color = DyeColor::WHITE();
		parent::__construct($idInfo, $name, $breakInfo);
	}

	public function onNearbyBlockChange() : void{
		if(($block = $this->checkAdjacentWater()) !== null){
			$this->pos->getWorld()->setBlock($this->pos, $block);
		}else{
			$this->startFalling();
		}
	}

	public function tickFalling() : ?Block{
		return $this->checkAdjacentWater();
	}

	private function checkAdjacentWater() : ?Block{
		foreach(Facing::ALL as $i){
			if($i === Facing::DOWN){
				continue;
			}
			if($this->getSide($i) instanceof Water){
				return VanillaBlocks::CONCRETE()->setColor($this->color);
			}
		}

		return null;
	}
}
