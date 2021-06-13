<?php

declare(strict_types=1);

namespace pocketmine\block\utils;

use function floor;

trait SignLikeRotationTrait{
	/** @var int */
	private $rotation = 0;

	public function getRotation() : int{ return $this->rotation; }

	/** @return $this */
	public function setRotation(int $rotation) : self{
		if($rotation < 0 || $rotation > 15){
			throw new \InvalidArgumentException("Rotation must be in range 0-15");
		}
		$this->rotation = $rotation;
		return $this;
	}

	private static function getRotationFromYaw(float $yaw) : int{
		return ((int) floor((($yaw + 180) * 16 / 360) + 0.5)) & 0xf;
	}
}
