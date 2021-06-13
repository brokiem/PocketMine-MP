<?php

declare(strict_types=1);

namespace pocketmine\block;

final class Beacon extends Transparent{

	public function getLightLevel() : int{
		return 15;
	}

	//TODO
}
