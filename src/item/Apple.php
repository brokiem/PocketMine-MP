<?php

declare(strict_types=1);

namespace pocketmine\item;

class Apple extends Food{

	public function getFoodRestore() : int{
		return 4;
	}

	public function getSaturationRestore() : float{
		return 2.4;
	}
}
