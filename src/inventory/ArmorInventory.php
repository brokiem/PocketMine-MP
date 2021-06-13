<?php

declare(strict_types=1);

namespace pocketmine\inventory;

use pocketmine\entity\Living;
use pocketmine\item\Item;

class ArmorInventory extends SimpleInventory{
	public const SLOT_HEAD = 0;
	public const SLOT_CHEST = 1;
	public const SLOT_LEGS = 2;
	public const SLOT_FEET = 3;

	/** @var Living */
	protected $holder;

	public function __construct(Living $holder){
		$this->holder = $holder;
		parent::__construct(4);
	}

	public function getHolder() : Living{
		return $this->holder;
	}

	public function getHelmet() : Item{
		return $this->getItem(self::SLOT_HEAD);
	}

	public function getChestplate() : Item{
		return $this->getItem(self::SLOT_CHEST);
	}

	public function getLeggings() : Item{
		return $this->getItem(self::SLOT_LEGS);
	}

	public function getBoots() : Item{
		return $this->getItem(self::SLOT_FEET);
	}

	public function setHelmet(Item $helmet) : void{
		$this->setItem(self::SLOT_HEAD, $helmet);
	}

	public function setChestplate(Item $chestplate) : void{
		$this->setItem(self::SLOT_CHEST, $chestplate);
	}

	public function setLeggings(Item $leggings) : void{
		$this->setItem(self::SLOT_LEGS, $leggings);
	}

	public function setBoots(Item $boots) : void{
		$this->setItem(self::SLOT_FEET, $boots);
	}
}
