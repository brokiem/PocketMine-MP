<?php

declare(strict_types=1);

namespace pocketmine\event\player;

use pocketmine\event\Cancellable;
use pocketmine\event\CancellableTrait;
use pocketmine\player\Player;

class PlayerToggleFlightEvent extends PlayerEvent implements Cancellable{
	use CancellableTrait;

	/** @var bool */
	protected $isFlying;

	public function __construct(Player $player, bool $isFlying){
		$this->player = $player;
		$this->isFlying = $isFlying;
	}

	public function isFlying() : bool{
		return $this->isFlying;
	}
}
