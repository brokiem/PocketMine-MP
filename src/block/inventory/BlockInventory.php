<?php

declare(strict_types=1);

namespace pocketmine\block\inventory;

use pocketmine\world\Position;

interface BlockInventory{
	public function getHolder() : Position;
}
