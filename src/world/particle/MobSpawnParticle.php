<?php

declare(strict_types=1);

namespace pocketmine\world\particle;

use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\LevelEventPacket;

class MobSpawnParticle implements Particle{
	/** @var int */
	protected $width;
	/** @var int */
	protected $height;

	public function __construct(int $width = 0, int $height = 0){
		//TODO: bounds checks
		$this->width = $width;
		$this->height = $height;
	}

	public function encode(Vector3 $pos) : array{
		return [LevelEventPacket::create(LevelEventPacket::EVENT_PARTICLE_SPAWN, ($this->width & 0xff) | (($this->height & 0xff) << 8), $pos)];
	}
}
