<?php

declare(strict_types=1);

namespace pocketmine\item;

class Beetroot extends Food{

	public function getFoodRestore() : int{
		return 1;
	}

	public function getSaturationRestore() : float{
		return 1.2;
	}
}
