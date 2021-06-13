<?php

declare(strict_types=1);

namespace pocketmine\event\player;

use pocketmine\block\Block;
use pocketmine\event\Cancellable;
use pocketmine\event\CancellableTrait;
use pocketmine\item\Item;
use pocketmine\player\Player;

/**
 * @allowHandle
 */
abstract class PlayerBucketEvent extends PlayerEvent implements Cancellable{
	use CancellableTrait;

	/** @var Block */
	private $blockClicked;
	/** @var int */
	private $blockFace;
	/** @var Item */
	private $bucket;
	/** @var Item */
	private $item;

	public function __construct(Player $who, Block $blockClicked, int $blockFace, Item $bucket, Item $itemInHand){
		$this->player = $who;
		$this->blockClicked = $blockClicked;
		$this->blockFace = $blockFace;
		$this->item = $itemInHand;
		$this->bucket = $bucket;
	}

	/**
	 * Returns the bucket used in this event
	 */
	public function getBucket() : Item{
		return $this->bucket;
	}

	/**
	 * Returns the item in hand after the event
	 */
	public function getItem() : Item{
		return $this->item;
	}

	public function setItem(Item $item) : void{
		$this->item = $item;
	}

	public function getBlockClicked() : Block{
		return $this->blockClicked;
	}

	public function getBlockFace() : int{
		return $this->blockFace;
	}
}
