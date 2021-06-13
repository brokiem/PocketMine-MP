<?php

declare(strict_types=1);

namespace pocketmine\event\player;

use pocketmine\event\Cancellable;
use pocketmine\event\CancellableTrait;
use pocketmine\player\GameMode;
use pocketmine\player\Player;

/**
 * Called when a player has its gamemode changed
 */
class PlayerGameModeChangeEvent extends PlayerEvent implements Cancellable{
	use CancellableTrait;

	/** @var GameMode */
	protected $gamemode;

	public function __construct(Player $player, GameMode $newGamemode){
		$this->player = $player;
		$this->gamemode = $newGamemode;
	}

	public function getNewGamemode() : GameMode{
		return $this->gamemode;
	}
}
