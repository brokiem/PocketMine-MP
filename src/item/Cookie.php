<?php

declare(strict_types=1);

namespace pocketmine\item;

class Cookie extends Food{

	public function getFoodRestore() : int{
		return 2;
	}

	public function getSaturationRestore() : float{
		return 0.4;
	}
}
