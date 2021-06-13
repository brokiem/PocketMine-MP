<?php

declare(strict_types=1);

namespace pocketmine\block;

class BrownMushroom extends RedMushroom{

	public function getLightLevel() : int{
		return 1;
	}
}
