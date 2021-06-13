<?php

declare(strict_types=1);

namespace pocketmine\item;

class CookedRabbit extends Food{

	public function getFoodRestore() : int{
		return 5;
	}

	public function getSaturationRestore() : float{
		return 6;
	}
}
