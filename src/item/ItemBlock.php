<?php

declare(strict_types=1);

namespace pocketmine\item;

use pocketmine\block\Block;
use pocketmine\block\BlockFactory;

/**
 * Class used for Items that can be Blocks
 */
class ItemBlock extends Item{
	/** @var int */
	private $blockFullId;

	public function __construct(ItemIdentifier $identifier, Block $block){
		parent::__construct($identifier, $block->getName());
		$this->blockFullId = $block->getFullId();
	}

	public function getBlock(?int $clickedFace = null) : Block{
		return BlockFactory::getInstance()->fromFullBlock($this->blockFullId);
	}

	public function getFuelTime() : int{
		return $this->getBlock()->getFuelTime();
	}
}
