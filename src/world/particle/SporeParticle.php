<?php

declare(strict_types=1);

namespace pocketmine\world\particle;

use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\LevelEventPacket;
use pocketmine\network\mcpe\protocol\types\ParticleIds;

class SporeParticle implements Particle{

	public function encode(Vector3 $pos) : array{
		return [LevelEventPacket::standardParticle(ParticleIds::TOWN_AURA, 0, $pos)];
	}
}
