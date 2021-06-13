<?php

declare(strict_types=1);

namespace pocketmine\block\inventory;

use pocketmine\inventory\SimpleInventory;
use pocketmine\player\Player;
use pocketmine\world\Position;

final class LoomInventory extends SimpleInventory implements BlockInventory{
	use BlockInventoryTrait;

	public const SLOT_BANNER = 0;
	public const SLOT_DYE = 1;
	public const SLOT_PATTERN = 2;

	public function __construct(Position $holder, int $size = 3){
		$this->holder = $holder;
		parent::__construct($size);
	}

	public function onClose(Player $who) : void{
		parent::onClose($who);

		foreach($this->getContents() as $item){
			$who->dropItem($item);
		}
		$this->clearAll();
	}
}
