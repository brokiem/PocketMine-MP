<?php

declare(strict_types=1);

namespace pocketmine\event\block;

use pocketmine\block\Block;
use pocketmine\event\Cancellable;
use pocketmine\event\CancellableTrait;

/**
 * Called when a block is burned away by fire.
 */
class BlockBurnEvent extends BlockEvent implements Cancellable{
	use CancellableTrait;

	/** @var Block */
	private $causingBlock;

	public function __construct(Block $block, Block $causingBlock){
		parent::__construct($block);
		$this->causingBlock = $causingBlock;
	}

	/**
	 * Returns the block (usually Fire) which caused the target block to be burned away.
	 */
	public function getCausingBlock() : Block{
		return $this->causingBlock;
	}
}
