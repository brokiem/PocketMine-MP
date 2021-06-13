<?php

declare(strict_types=1);

namespace pocketmine\item;

class RawBeef extends Food{

	public function getFoodRestore() : int{
		return 3;
	}

	public function getSaturationRestore() : float{
		return 1.8;
	}
}
