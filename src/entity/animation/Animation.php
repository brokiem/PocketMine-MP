<?php

declare(strict_types=1);

namespace pocketmine\entity\animation;

use pocketmine\network\mcpe\protocol\ClientboundPacket;

/**
 * Represents an animation such as an arm swing, or other visual effect done by entities.
 */
interface Animation{
	/**
	 * @return ClientboundPacket[]
	 */
	public function encode() : array;
}
