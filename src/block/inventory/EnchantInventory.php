<?php

declare(strict_types=1);

namespace pocketmine\block\inventory;

use pocketmine\inventory\SimpleInventory;
use pocketmine\player\Player;
use pocketmine\world\Position;

class EnchantInventory extends SimpleInventory implements BlockInventory{
	use BlockInventoryTrait;

	public function __construct(Position $holder){
		$this->holder = $holder;
		parent::__construct(2);
	}

	public function onClose(Player $who) : void{
		parent::onClose($who);

		foreach($this->getContents() as $item){
			$who->dropItem($item);
		}
		$this->clearAll();
	}
}
