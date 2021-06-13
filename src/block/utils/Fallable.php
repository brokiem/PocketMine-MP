<?php

declare(strict_types=1);

namespace pocketmine\block\utils;

use pocketmine\block\Block;

interface Fallable{

	/**
	 * Called every tick by FallingBlock to update the falling state of this block. Used by concrete to check when it
	 * hits water.
	 * Return null if you don't want to change the usual behaviour.
	 */
	public function tickFalling() : ?Block;
}
