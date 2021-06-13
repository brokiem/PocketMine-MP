<?php

declare(strict_types=1);

namespace pocketmine\event\player;

use pocketmine\player\Player;
use pocketmine\world\Position;

/**
 * Called when a player is respawned
 */
class PlayerRespawnEvent extends PlayerEvent{
	/** @var Position */
	protected $position;

	public function __construct(Player $player, Position $position){
		$this->player = $player;
		$this->position = $position;
	}

	public function getRespawnPosition() : Position{
		return $this->position;
	}

	public function setRespawnPosition(Position $position) : void{
		if(!$position->isValid()){
			throw new \InvalidArgumentException("Spawn position must reference a valid and loaded World");
		}
		$this->position = $position;
	}
}
