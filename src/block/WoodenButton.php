<?php

declare(strict_types=1);

namespace pocketmine\block;

class WoodenButton extends Button{

	protected function getActivationTime() : int{
		return 30;
	}

	public function hasEntityCollision() : bool{
		return false; //TODO: arrows activate wooden buttons
	}
}
