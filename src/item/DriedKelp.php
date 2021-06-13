<?php

declare(strict_types=1);

namespace pocketmine\item;

class DriedKelp extends Food{

	public function getFoodRestore() : int{
		return 1;
	}

	public function getSaturationRestore() : float{
		return 0.6;
	}
}
