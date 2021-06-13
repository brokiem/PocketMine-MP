<?php

declare(strict_types=1);

namespace pocketmine\block;

class DriedKelp extends Opaque{

	public function getFlameEncouragement() : int{
		return 30;
	}

	public function getFlammability() : int{
		return 60;
	}

	public function getFuelTime() : int{
		return 4000;
	}
}
