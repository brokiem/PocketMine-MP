<?php

declare(strict_types=1);

namespace pocketmine\world\particle;

use pocketmine\math\Vector3;
use pocketmine\network\mcpe\convert\RuntimeBlockMapping;
use pocketmine\network\mcpe\protocol\LevelEventPacket;

class BlockBreakParticle extends MappingParticle{

	public function encode(Vector3 $pos) : array{
		return [LevelEventPacket::create(LevelEventPacket::EVENT_PARTICLE_DESTROY, RuntimeBlockMapping::getInstance()->toRuntimeId($this->block->getFullId(), $this->mappingProtocol), $pos)];
	}
}
