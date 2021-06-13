<?php

declare(strict_types=1);

namespace pocketmine\world\particle;

use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\LevelEventPacket;
use pocketmine\network\mcpe\protocol\types\ParticleIds;

class EntityFlameParticle implements Particle{

	public function encode(Vector3 $pos) : array{
		return [LevelEventPacket::standardParticle(ParticleIds::MOB_FLAME, 0, $pos)];
	}
}
