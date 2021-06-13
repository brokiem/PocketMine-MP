<?php

declare(strict_types=1);

namespace pocketmine\world\sound;

use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\ClientboundPacket;

interface Sound{

	/**
	 * @return ClientboundPacket[]
	 */
	public function encode(?Vector3 $pos) : array;
}
