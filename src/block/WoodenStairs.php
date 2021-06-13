<?php

declare(strict_types=1);

namespace pocketmine\block;

class WoodenStairs extends Stair{

	public function getFlameEncouragement() : int{
		return 5;
	}

	public function getFlammability() : int{
		return 20;
	}
}
