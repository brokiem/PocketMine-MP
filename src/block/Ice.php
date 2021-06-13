<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\item\enchantment\VanillaEnchantments;
use pocketmine\item\Item;
use pocketmine\player\Player;

class Ice extends Transparent{

	public function getLightFilter() : int{
		return 2;
	}

	public function getFrictionFactor() : float{
		return 0.98;
	}

	public function onBreak(Item $item, ?Player $player = null) : bool{
		if(($player === null or $player->isSurvival()) and !$item->hasEnchantment(VanillaEnchantments::SILK_TOUCH())){
			$this->pos->getWorld()->setBlock($this->pos, VanillaBlocks::WATER());
			return true;
		}
		return parent::onBreak($item, $player);
	}

	public function ticksRandomly() : bool{
		return true;
	}

	public function onRandomTick() : void{
		if($this->pos->getWorld()->getHighestAdjacentBlockLight($this->pos->x, $this->pos->y, $this->pos->z) >= 12){
			$this->pos->getWorld()->useBreakOn($this->pos);
		}
	}

	public function getDropsForCompatibleTool(Item $item) : array{
		return [];
	}

	public function isAffectedBySilkTouch() : bool{
		return true;
	}
}
