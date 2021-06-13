<?php

declare(strict_types=1);

namespace pocketmine\event\player;

use pocketmine\block\Block;
use pocketmine\event\Cancellable;
use pocketmine\event\CancellableTrait;
use pocketmine\item\Item;
use pocketmine\math\Vector3;
use pocketmine\player\Player;

/**
 * Called when a player interacts or touches a block (including air?)
 */
class PlayerInteractEvent extends PlayerEvent implements Cancellable{
	use CancellableTrait;

	public const LEFT_CLICK_BLOCK = 0;
	public const RIGHT_CLICK_BLOCK = 1;

	/** @var Block */
	protected $blockTouched;

	/** @var Vector3 */
	protected $touchVector;

	/** @var int */
	protected $blockFace;

	/** @var Item */
	protected $item;

	/** @var int */
	protected $action;

	public function __construct(Player $player, Item $item, Block $block, ?Vector3 $touchVector, int $face, int $action = PlayerInteractEvent::RIGHT_CLICK_BLOCK){
		$this->player = $player;
		$this->item = $item;
		$this->blockTouched = $block;
		$this->touchVector = $touchVector ?? new Vector3(0, 0, 0);
		$this->blockFace = $face;
		$this->action = $action;
	}

	public function getAction() : int{
		return $this->action;
	}

	public function getItem() : Item{
		return $this->item;
	}

	public function getBlock() : Block{
		return $this->blockTouched;
	}

	public function getTouchVector() : Vector3{
		return $this->touchVector;
	}

	public function getFace() : int{
		return $this->blockFace;
	}
}
