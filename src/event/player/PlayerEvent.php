<?php

declare(strict_types=1);

/**
 * Player-only related events
 */
namespace pocketmine\event\player;

use pocketmine\event\Event;
use pocketmine\player\Player;

abstract class PlayerEvent extends Event{
	/** @var Player */
	protected $player;

	public function getPlayer() : Player{
		return $this->player;
	}
}
