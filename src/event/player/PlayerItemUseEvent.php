<?php

declare(strict_types=1);

namespace pocketmine\event\player;

use pocketmine\event\Cancellable;
use pocketmine\event\CancellableTrait;
use pocketmine\item\Item;
use pocketmine\math\Vector3;
use pocketmine\player\Player;

/**
 * Called when a player uses its held item, for example when throwing a projectile.
 */
class PlayerItemUseEvent extends PlayerEvent implements Cancellable{
	use CancellableTrait;

	/** @var Item */
	private $item;
	/** @var Vector3 */
	private $directionVector;

	public function __construct(Player $player, Item $item, Vector3 $directionVector){
		$this->player = $player;
		$this->item = $item;
		$this->directionVector = $directionVector;
	}

	/**
	 * Returns the item used.
	 */
	public function getItem() : Item{
		return $this->item;
	}

	/**
	 * Returns the direction the player is aiming when activating this item. Used for projectile direction.
	 */
	public function getDirectionVector() : Vector3{
		return $this->directionVector;
	}
}
