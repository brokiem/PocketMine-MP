<?php

declare(strict_types=1);

namespace pocketmine\item;

class CookedChicken extends Food{

	public function getFoodRestore() : int{
		return 6;
	}

	public function getSaturationRestore() : float{
		return 7.2;
	}
}
