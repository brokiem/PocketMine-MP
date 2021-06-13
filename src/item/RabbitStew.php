<?php

declare(strict_types=1);

namespace pocketmine\item;

class RabbitStew extends Food{

	public function getMaxStackSize() : int{
		return 1;
	}

	public function getFoodRestore() : int{
		return 10;
	}

	public function getSaturationRestore() : float{
		return 12;
	}

	public function getResidue() : Item{
		return VanillaItems::BOWL();
	}
}
