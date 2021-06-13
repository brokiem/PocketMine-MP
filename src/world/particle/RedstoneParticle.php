<?php

declare(strict_types=1);

namespace pocketmine\world\particle;

use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\LevelEventPacket;
use pocketmine\network\mcpe\protocol\types\ParticleIds;

class RedstoneParticle implements Particle{
	/** @var int */
	private $lifetime;

	public function __construct(int $lifetime = 1){
		$this->lifetime = $lifetime;
	}

	public function encode(Vector3 $pos) : array{
		return [LevelEventPacket::standardParticle(ParticleIds::REDSTONE, $this->lifetime, $pos)];
	}
}
