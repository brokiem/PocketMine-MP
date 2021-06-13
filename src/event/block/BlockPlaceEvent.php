<?php

declare(strict_types=1);

namespace pocketmine\event\block;

use pocketmine\block\Block;
use pocketmine\event\Cancellable;
use pocketmine\event\CancellableTrait;
use pocketmine\item\Item;
use pocketmine\player\Player;

/**
 * Called when a player places a block
 */
class BlockPlaceEvent extends BlockEvent implements Cancellable{
	use CancellableTrait;

	/** @var Player */
	protected $player;

	/** @var Item */
	protected $item;

	/** @var Block */
	protected $blockReplace;
	/** @var Block */
	protected $blockAgainst;

	public function __construct(Player $player, Block $blockPlace, Block $blockReplace, Block $blockAgainst, Item $item){
		parent::__construct($blockPlace);
		$this->blockReplace = $blockReplace;
		$this->blockAgainst = $blockAgainst;
		$this->item = $item;
		$this->player = $player;
	}

	/**
	 * Returns the player who is placing the block.
	 */
	public function getPlayer() : Player{
		return $this->player;
	}

	/**
	 * Gets the item in hand
	 */
	public function getItem() : Item{
		return $this->item;
	}

	public function getBlockReplaced() : Block{
		return $this->blockReplace;
	}

	public function getBlockAgainst() : Block{
		return $this->blockAgainst;
	}
}
