<?php

declare(strict_types=1);

namespace pocketmine\item;

class Sign extends ItemBlockWallOrFloor{

	public function getMaxStackSize() : int{
		return 16;
	}
}
