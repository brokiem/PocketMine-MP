<?php

declare(strict_types=1);

namespace pocketmine\block\utils;

use pocketmine\math\Axis;
use pocketmine\math\Facing;

trait HorizontalFacingTrait{
	/** @var int */
	protected $facing = Facing::NORTH;

	public function getFacing() : int{ return $this->facing; }

	/** @return $this */
	public function setFacing(int $facing) : self{
		$axis = Facing::axis($facing);
		if($axis !== Axis::X && $axis !== Axis::Z){
			throw new \InvalidArgumentException("Facing must be horizontal");
		}
		$this->facing = $facing;
		return $this;
	}
}
