<?php

declare(strict_types=1);

namespace pocketmine\event\player;

use pocketmine\event\Cancellable;
use pocketmine\event\CancellableTrait;
use pocketmine\player\Player;

class PlayerToggleSprintEvent extends PlayerEvent implements Cancellable{
	use CancellableTrait;

	/** @var bool */
	protected $isSprinting;

	public function __construct(Player $player, bool $isSprinting){
		$this->player = $player;
		$this->isSprinting = $isSprinting;
	}

	public function isSprinting() : bool{
		return $this->isSprinting;
	}
}
