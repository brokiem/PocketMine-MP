<?php

declare(strict_types=1);

namespace pocketmine\event\block;

use pocketmine\block\Block;

/**
 * Called when a block spreads to another block, such as grass spreading to nearby dirt blocks.
 */
class BlockSpreadEvent extends BaseBlockChangeEvent{
	/** @var Block */
	private $source;

	public function __construct(Block $block, Block $source, Block $newState){
		parent::__construct($block, $newState);
		$this->source = $source;
	}

	public function getSource() : Block{
		return $this->source;
	}
}
