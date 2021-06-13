<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe;

use pocketmine\network\mcpe\protocol\ClientboundPacket;

interface PacketBroadcaster{

	/**
	 * @param NetworkSession[] $recipients
	 * @param ClientboundPacket[] $packets
	 */
	public function broadcastPackets(array $recipients, array $packets) : void;
}
