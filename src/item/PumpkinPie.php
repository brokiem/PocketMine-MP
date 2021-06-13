<?php

declare(strict_types=1);

namespace pocketmine\item;

class PumpkinPie extends Food{

	public function getFoodRestore() : int{
		return 8;
	}

	public function getSaturationRestore() : float{
		return 4.8;
	}
}
