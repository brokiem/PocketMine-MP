<?php

declare(strict_types=1);

namespace pocketmine\event\player;

use pocketmine\block\Block;
use pocketmine\event\Cancellable;
use pocketmine\event\CancellableTrait;
use pocketmine\item\Item;
use pocketmine\player\Player;

/**
 * Called when a player middle-clicks on a block to get an item in creative mode.
 */
class PlayerBlockPickEvent extends PlayerEvent implements Cancellable{
	use CancellableTrait;

	/** @var Block */
	private $blockClicked;
	/** @var Item */
	private $resultItem;

	public function __construct(Player $player, Block $blockClicked, Item $resultItem){
		$this->player = $player;
		$this->blockClicked = $blockClicked;
		$this->resultItem = $resultItem;
	}

	public function getBlock() : Block{
		return $this->blockClicked;
	}

	public function getResultItem() : Item{
		return $this->resultItem;
	}
}
