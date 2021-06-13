<?php

declare(strict_types=1);

namespace pocketmine\world\particle;

use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\LevelEventPacket;
use pocketmine\network\mcpe\protocol\types\ParticleIds;

class HeartParticle implements Particle{
	/** @var int */
	private $scale;

	public function __construct(int $scale = 0){
		$this->scale = $scale;
	}

	public function encode(Vector3 $pos) : array{
		return [LevelEventPacket::standardParticle(ParticleIds::HEART, $this->scale, $pos)];
	}
}
