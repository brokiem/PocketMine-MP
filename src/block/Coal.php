<?php

declare(strict_types=1);

namespace pocketmine\block;

class Coal extends Opaque{

	public function getFuelTime() : int{
		return 16000;
	}

	public function getFlameEncouragement() : int{
		return 5;
	}

	public function getFlammability() : int{
		return 5;
	}
}
