<?php

declare(strict_types=1);

namespace pocketmine\item;

class Steak extends Food{

	public function getFoodRestore() : int{
		return 8;
	}

	public function getSaturationRestore() : float{
		return 12.8;
	}
}
