<?php

declare(strict_types=1);

namespace pocketmine\block;

class Netherrack extends Opaque{

	public function burnsForever() : bool{
		return true;
	}
}
