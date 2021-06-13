<?php

declare(strict_types=1);

namespace pocketmine\block;

class WoodenTrapdoor extends Trapdoor{

	public function getFuelTime() : int{
		return 300;
	}
}
