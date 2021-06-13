<?php

declare(strict_types=1);

namespace pocketmine\world\particle;

use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\LevelEventPacket;

class EndermanTeleportParticle implements Particle{

	public function encode(Vector3 $pos) : array{
		return [LevelEventPacket::create(LevelEventPacket::EVENT_PARTICLE_ENDERMAN_TELEPORT, 0, $pos)];
	}
}
