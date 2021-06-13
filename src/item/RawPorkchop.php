<?php

declare(strict_types=1);

namespace pocketmine\item;

class RawPorkchop extends Food{

	public function getFoodRestore() : int{
		return 3;
	}

	public function getSaturationRestore() : float{
		return 0.6;
	}
}
