<?php

declare(strict_types=1);

namespace pocketmine\event\player;

use pocketmine\player\Player;

/**
 * Called when a player jumps
 */
class PlayerJumpEvent extends PlayerEvent{

	/**
	 * PlayerJumpEvent constructor.
	 */
	public function __construct(Player $player){
		$this->player = $player;
	}
}
