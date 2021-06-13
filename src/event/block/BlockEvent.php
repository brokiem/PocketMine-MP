<?php

declare(strict_types=1);

/**
 * Block related events
 */
namespace pocketmine\event\block;

use pocketmine\block\Block;
use pocketmine\event\Event;

abstract class BlockEvent extends Event{
	/** @var Block */
	protected $block;

	public function __construct(Block $block){
		$this->block = $block;
	}

	public function getBlock() : Block{
		return $this->block;
	}
}
