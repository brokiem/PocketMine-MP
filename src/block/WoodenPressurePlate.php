<?php

declare(strict_types=1);

namespace pocketmine\block;

class WoodenPressurePlate extends SimplePressurePlate{

	public function getFuelTime() : int{
		return 300;
	}
}
