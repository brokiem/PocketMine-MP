<?php

declare(strict_types=1);

namespace pocketmine\block;

class UnderwaterTorch extends Torch{

	public function canBeFlowedInto() : bool{
		return false;
	}
}
