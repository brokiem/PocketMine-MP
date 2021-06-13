<?php

declare(strict_types=1);

namespace pocketmine\item;

class BakedPotato extends Food{

	public function getFoodRestore() : int{
		return 5;
	}

	public function getSaturationRestore() : float{
		return 7.2;
	}
}
