<?php

declare(strict_types=1);

namespace pocketmine\block\utils;

use pocketmine\math\Facing;

trait AnyFacingTrait{
	/** @var int */
	protected $facing = Facing::DOWN;

	public function getFacing() : int{ return $this->facing; }

	/** @return $this */
	public function setFacing(int $facing) : self{
		Facing::validate($this->facing);
		$this->facing = $facing;
		return $this;
	}
}
