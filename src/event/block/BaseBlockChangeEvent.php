<?php

declare(strict_types=1);

namespace pocketmine\event\block;

use pocketmine\block\Block;
use pocketmine\event\Cancellable;
use pocketmine\event\CancellableTrait;

/**
 * @internal
 */
abstract class BaseBlockChangeEvent extends BlockEvent implements Cancellable{
	use CancellableTrait;

	private Block $newState;

	public function __construct(Block $block, Block $newState){
		parent::__construct($block);
		$this->newState = $newState;
	}

	public function getNewState() : Block{
		return $this->newState;
	}
}
