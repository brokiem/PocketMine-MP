<?php

declare(strict_types=1);

namespace pocketmine\event\player;

use pocketmine\block\Block;
use pocketmine\player\Player;

class PlayerBedLeaveEvent extends PlayerEvent{
	/** @var Block */
	private $bed;

	public function __construct(Player $player, Block $bed){
		$this->player = $player;
		$this->bed = $bed;
	}

	public function getBed() : Block{
		return $this->bed;
	}
}
