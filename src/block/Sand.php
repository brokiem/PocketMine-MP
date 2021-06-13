<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\block\utils\Fallable;
use pocketmine\block\utils\FallableTrait;

class Sand extends Opaque implements Fallable{
	use FallableTrait;

	public function tickFalling() : ?Block{
		return null;
	}
}
