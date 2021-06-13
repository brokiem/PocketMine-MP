<?php

declare(strict_types=1);

namespace pocketmine\event\player;

use pocketmine\lang\TranslationContainer;
use pocketmine\player\Player;

/**
 * Called when a player leaves the server
 */
class PlayerQuitEvent extends PlayerEvent{

	/** @var TranslationContainer|string */
	protected $quitMessage;
	/** @var string */
	protected $quitReason;

	/**
	 * @param TranslationContainer|string $quitMessage
	 */
	public function __construct(Player $player, $quitMessage, string $quitReason){
		$this->player = $player;
		$this->quitMessage = $quitMessage;
		$this->quitReason = $quitReason;
	}

	/**
	 * @param TranslationContainer|string $quitMessage
	 */
	public function setQuitMessage($quitMessage) : void{
		$this->quitMessage = $quitMessage;
	}

	/**
	 * @return TranslationContainer|string
	 */
	public function getQuitMessage(){
		return $this->quitMessage;
	}

	public function getQuitReason() : string{
		return $this->quitReason;
	}
}
