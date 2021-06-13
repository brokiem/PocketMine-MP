<?php

declare(strict_types=1);

namespace pocketmine\block;

class WoodenFence extends Fence{

	public function getFuelTime() : int{
		return 300;
	}

	public function getFlameEncouragement() : int{
		return 5;
	}

	public function getFlammability() : int{
		return 20;
	}
}
