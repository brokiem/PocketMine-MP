<?php

declare(strict_types=1);

namespace pocketmine\item;

use pocketmine\block\Block;
use pocketmine\block\BlockFactory;
use pocketmine\math\Axis;
use pocketmine\math\Facing;

class ItemBlockWallOrFloor extends Item{

	/** @var int */
	private $floorVariant;
	/** @var int */
	private $wallVariant;

	public function __construct(ItemIdentifier $identifier, Block $floorVariant, Block $wallVariant){
		parent::__construct($identifier, $floorVariant->getName());
		$this->floorVariant = $floorVariant->getFullId();
		$this->wallVariant = $wallVariant->getFullId();
	}

	public function getBlock(?int $clickedFace = null) : Block{
		if($clickedFace !== null && Facing::axis($clickedFace) !== Axis::Y){
			return BlockFactory::getInstance()->fromFullBlock($this->wallVariant);
		}
		return BlockFactory::getInstance()->fromFullBlock($this->floorVariant);
	}

	public function getFuelTime() : int{
		return $this->getBlock()->getFuelTime();
	}
}
