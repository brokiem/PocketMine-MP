<?php

declare(strict_types=1);

namespace pocketmine\event\player;

use pocketmine\player\Player;

class PlayerDisplayNameChangeEvent extends PlayerEvent{

	/** @var string */
	private $oldName;
	/** @var string */
	private $newName;

	public function __construct(Player $player, string $oldName, string $newName){
		$this->player = $player;
		$this->oldName = $oldName;
		$this->newName = $newName;
	}

	public function getOldName() : string{
		return $this->oldName;
	}

	public function getNewName() : string{
		return $this->newName;
	}
}