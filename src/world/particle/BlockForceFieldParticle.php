<?php

declare(strict_types=1);

namespace pocketmine\world\particle;

use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\LevelEventPacket;
use pocketmine\network\mcpe\protocol\types\ParticleIds;

class BlockForceFieldParticle implements Particle{

	/** @var int */
	private $data;

	public function __construct(int $data = 0){
		$this->data = $data; //TODO: proper encode/decode of data
	}

	public function encode(Vector3 $pos) : array{
		return [LevelEventPacket::standardParticle(ParticleIds::BLOCK_FORCE_FIELD, $this->data, $pos)];
	}
}
