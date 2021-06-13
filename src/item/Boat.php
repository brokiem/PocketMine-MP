<?php

declare(strict_types=1);

namespace pocketmine\item;

use pocketmine\block\utils\TreeType;

class Boat extends Item{
	/** @var TreeType */
	private $woodType;

	public function __construct(ItemIdentifier $identifier, string $name, TreeType $woodType){
		parent::__construct($identifier, $name);
		$this->woodType = $woodType;
	}

	public function getWoodType() : TreeType{
		return $this->woodType;
	}

	public function getFuelTime() : int{
		return 1200; //400 in PC
	}

	//TODO
}
