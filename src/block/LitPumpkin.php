<?php

declare(strict_types=1);

namespace pocketmine\block;

class LitPumpkin extends CarvedPumpkin{

	public function getLightLevel() : int{
		return 15;
	}
}
