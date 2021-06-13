<?php

declare(strict_types=1);

namespace pocketmine\event\player;

use pocketmine\event\Cancellable;
use pocketmine\event\CancellableTrait;
use pocketmine\lang\TranslationContainer;
use pocketmine\player\Player;

/**
 * Called when a player leaves the server
 */
class PlayerKickEvent extends PlayerEvent implements Cancellable{
	use CancellableTrait;

	/** @var TranslationContainer|string */
	protected $quitMessage;

	/** @var string */
	protected $reason;

	/**
	 * PlayerKickEvent constructor.
	 *
	 * @param TranslationContainer|string $quitMessage
	 */
	public function __construct(Player $player, string $reason, $quitMessage){
		$this->player = $player;
		$this->quitMessage = $quitMessage;
		$this->reason = $reason;
	}

	public function setReason(string $reason) : void{
		$this->reason = $reason;
	}

	public function getReason() : string{
		return $this->reason;
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
}
