<?php

declare(strict_types=1);

namespace pocketmine\item;

class Coal extends Item{

	public function getFuelTime() : int{
		return 1600;
	}
}
