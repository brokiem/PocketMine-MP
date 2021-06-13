<?php

declare(strict_types=1);

namespace pocketmine\block;

class StoneButton extends Button{

	protected function getActivationTime() : int{
		return 20;
	}
}
