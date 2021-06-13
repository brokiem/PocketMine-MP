<?php

declare(strict_types=1);

namespace pocketmine\world\particle;

use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\LevelEventPacket;
use function abs;

class DragonEggTeleportParticle implements Particle{

	/** @var int */
	private $xDiff;
	/** @var int */
	private $yDiff;
	/** @var int */
	private $zDiff;

	public function __construct(int $xDiff, int $yDiff, int $zDiff){
		$this->xDiff = self::boundOrThrow($xDiff);
		$this->yDiff = self::boundOrThrow($yDiff);
		$this->zDiff = self::boundOrThrow($zDiff);
	}

	private static function boundOrThrow(int $v) : int{
		if($v < -255 or $v > 255){
			throw new \InvalidArgumentException("Value must be between -255 and 255");
		}
		return $v;
	}

	public function encode(Vector3 $pos) : array{
		$data = ($this->zDiff < 0 ? 1 << 26 : 0) |
			($this->yDiff < 0 ? 1 << 25 : 0) |
			($this->xDiff < 0 ? 1 << 24 : 0) |
			(abs($this->xDiff) << 16) |
			(abs($this->yDiff) << 8) |
			abs($this->zDiff);

		return [LevelEventPacket::create(LevelEventPacket::EVENT_PARTICLE_DRAGON_EGG_TELEPORT, $data, $pos)];
	}
}
