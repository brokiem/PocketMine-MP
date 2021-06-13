<?php

declare(strict_types=1);

namespace pocketmine\block\inventory;

use pocketmine\inventory\SimpleInventory;
use pocketmine\item\Item;
use pocketmine\world\Position;

class FurnaceInventory extends SimpleInventory implements BlockInventory{
	use BlockInventoryTrait;

	public function __construct(Position $holder){
		$this->holder = $holder;
		parent::__construct(3);
	}

	public function getResult() : Item{
		return $this->getItem(2);
	}

	public function getFuel() : Item{
		return $this->getItem(1);
	}

	public function getSmelting() : Item{
		return $this->getItem(0);
	}

	public function setResult(Item $item) : void{
		$this->setItem(2, $item);
	}

	public function setFuel(Item $item) : void{
		$this->setItem(1, $item);
	}

	public function setSmelting(Item $item) : void{
		$this->setItem(0, $item);
	}
}
