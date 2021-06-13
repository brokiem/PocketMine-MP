<?php

declare(strict_types=1);

namespace pocketmine\item;

class CookedSalmon extends Food{

	public function getFoodRestore() : int{
		return 6;
	}

	public function getSaturationRestore() : float{
		return 9.6;
	}
}
