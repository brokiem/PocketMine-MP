<?php

declare(strict_types=1);

namespace pocketmine\world\particle;

use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\LevelEventPacket;
use pocketmine\network\mcpe\protocol\types\ParticleIds;

class RainSplashParticle implements Particle{

	public function encode(Vector3 $pos) : array{
		return [LevelEventPacket::standardParticle(ParticleIds::RAIN_SPLASH, 0, $pos)];
	}
}
