<?php

declare(strict_types=1);

namespace pocketmine\event\player;

use pocketmine\event\Cancellable;
use pocketmine\event\CancellableTrait;
use pocketmine\player\Player;

/**
 * Called after the player has successfully authenticated, before it spawns. The player is on the loading screen when
 * this is called.
 * Cancelling this event will cause the player to be disconnected with the kick message set.
 */
class PlayerLoginEvent extends PlayerEvent implements Cancellable{
	use CancellableTrait;

	/** @var string */
	protected $kickMessage;

	public function __construct(Player $player, string $kickMessage){
		$this->player = $player;
		$this->kickMessage = $kickMessage;
	}

	public function setKickMessage(string $kickMessage) : void{
		$this->kickMessage = $kickMessage;
	}

	public function getKickMessage() : string{
		return $this->kickMessage;
	}
}
