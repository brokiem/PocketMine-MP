<?php

declare(strict_types=1);

namespace pocketmine\event\player;

use pocketmine\event\Cancellable;
use pocketmine\event\CancellableTrait;
use pocketmine\player\Player;

class PlayerToggleSneakEvent extends PlayerEvent implements Cancellable{
	use CancellableTrait;

	/** @var bool */
	protected $isSneaking;

	public function __construct(Player $player, bool $isSneaking){
		$this->player = $player;
		$this->isSneaking = $isSneaking;
	}

	public function isSneaking() : bool{
		return $this->isSneaking;
	}
}
