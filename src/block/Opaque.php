<?php

declare(strict_types=1);

namespace pocketmine\block;

class Opaque extends Block{

	public function isSolid() : bool{
		return true;
	}
}
