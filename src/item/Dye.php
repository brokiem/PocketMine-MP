<?php

declare(strict_types=1);

namespace pocketmine\item;

use pocketmine\block\utils\DyeColor;

class Dye extends Item{

	/** @var DyeColor */
	private $color;

	public function __construct(ItemIdentifier $identifier, string $name, DyeColor $color){
		parent::__construct($identifier, $name);
		$this->color = $color;
	}

	public function getColor() : DyeColor{
		return $this->color;
	}
}
