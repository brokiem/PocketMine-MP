<?php

declare(strict_types=1);

namespace pocketmine\block;

class GlowingObsidian extends Opaque{

	public function getLightLevel() : int{
		return 12;
	}
}
