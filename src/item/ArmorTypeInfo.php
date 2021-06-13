<?php

declare(strict_types=1);

namespace pocketmine\item;

class ArmorTypeInfo{

	/** @var int */
	private $defensePoints;
	/** @var int */
	private $maxDurability;
	/** @var int */
	private $armorSlot;

	public function __construct(int $defensePoints, int $maxDurability, int $armorSlot){
		$this->defensePoints = $defensePoints;
		$this->maxDurability = $maxDurability;
		$this->armorSlot = $armorSlot;
	}

	public function getDefensePoints() : int{
		return $this->defensePoints;
	}

	public function getMaxDurability() : int{
		return $this->maxDurability;
	}

	public function getArmorSlot() : int{
		return $this->armorSlot;
	}
}
