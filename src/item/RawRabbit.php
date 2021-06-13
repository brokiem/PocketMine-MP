<?php

declare(strict_types=1);

namespace pocketmine\item;

class RawRabbit extends Food{

	public function getFoodRestore() : int{
		return 3;
	}

	public function getSaturationRestore() : float{
		return 1.8;
	}
}
