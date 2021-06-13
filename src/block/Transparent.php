<?php

declare(strict_types=1);

namespace pocketmine\block;

class Transparent extends Block{

	public function isTransparent() : bool{
		return true;
	}
}
