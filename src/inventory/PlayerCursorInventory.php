<?php

declare(strict_types=1);

namespace pocketmine\inventory;

use pocketmine\player\Player;

class PlayerCursorInventory extends SimpleInventory{
	/** @var Player */
	protected $holder;

	public function __construct(Player $holder){
		$this->holder = $holder;
		parent::__construct(1);
	}

	/**
	 * @return Player
	 */
	public function getHolder(){
		return $this->holder;
	}
}
