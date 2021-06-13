<?php

declare(strict_types=1);

namespace pocketmine\item;

use pocketmine\block\Block;
use pocketmine\block\utils\DyeColor;
use pocketmine\block\VanillaBlocks;

class Bed extends Item{

	/** @var DyeColor */
	private $color;

	public function __construct(ItemIdentifier $identifier, string $name, DyeColor $color){
		parent::__construct($identifier, $name);
		$this->color = $color;
	}

	public function getColor() : DyeColor{
		return $this->color;
	}

	public function getBlock(?int $clickedFace = null) : Block{
		return VanillaBlocks::BED();
	}

	public function getMaxStackSize() : int{
		return 1;
	}
}
