<?php

declare(strict_types=1);

namespace pocketmine\world\particle;

use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\LevelEventPacket;
use pocketmine\network\mcpe\protocol\types\ParticleIds;

class CriticalParticle implements Particle{
	/** @var int */
	private $scale;

	public function __construct(int $scale = 2){
		$this->scale = $scale;
	}

	public function encode(Vector3 $pos) : array{
		return [LevelEventPacket::standardParticle(ParticleIds::CRITICAL, $this->scale, $pos)];
	}
}
