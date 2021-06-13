<?php

declare(strict_types=1);

namespace pocketmine\world\particle;

use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\ClientboundPacket;

interface Particle{

	/**
	 * @return ClientboundPacket[]
	 */
	public function encode(Vector3 $pos) : array;

}
