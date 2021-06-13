<?php

declare(strict_types=1);

namespace pocketmine\item;

class RawSalmon extends Food{

	public function getFoodRestore() : int{
		return 2;
	}

	public function getSaturationRestore() : float{
		return 0.2;
	}
}
