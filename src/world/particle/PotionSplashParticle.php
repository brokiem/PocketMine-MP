<?php

declare(strict_types=1);

namespace pocketmine\world\particle;

use pocketmine\color\Color;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\LevelEventPacket;

class PotionSplashParticle implements Particle{

	/** @var Color */
	private $color;

	public function __construct(Color $color){
		$this->color = $color;
	}

	/**
	 * Returns the default water-bottle splash colour.
	 *
	 * TODO: replace this with a standard surrogate object constant (first we need to implement them!)
	 */
	public static function DEFAULT_COLOR() : Color{
		return new Color(0x38, 0x5d, 0xc6);
	}

	public function getColor() : Color{
		return $this->color;
	}

	public function encode(Vector3 $pos) : array{
		return [LevelEventPacket::create(LevelEventPacket::EVENT_PARTICLE_SPLASH, $this->color->toARGB(), $pos)];
	}
}
