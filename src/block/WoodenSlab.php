<?php

declare(strict_types=1);

namespace pocketmine\block;

class WoodenSlab extends Slab{

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
