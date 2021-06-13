<?php

declare(strict_types=1);

namespace pocketmine\block\utils;

trait ColoredTrait{
	/** @var DyeColor */
	private $color;

	public function getColor() : DyeColor{ return $this->color; }

	/** @return $this */
	public function setColor(DyeColor $color) : self{
		$this->color = $color;
		return $this;
	}
}
