<?php

declare(strict_types=1);

namespace pocketmine\world\particle;

use pocketmine\color\Color;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\LevelEventPacket;
use pocketmine\network\mcpe\protocol\types\ParticleIds;

class EnchantParticle implements Particle{

	/** @var Color */
	private $color;

	public function __construct(Color $color){
		$this->color = $color;
	}

	public function encode(Vector3 $pos) : array{
		return [LevelEventPacket::standardParticle(ParticleIds::MOB_SPELL, $this->color->toARGB(), $pos)];
	}
}
