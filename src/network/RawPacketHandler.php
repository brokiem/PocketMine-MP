<?php

declare(strict_types=1);

namespace pocketmine\network;

interface RawPacketHandler{

	/**
	 * Returns a preg_match() compatible regex pattern used to filter packets on this handler. Only packets matching
	 * this pattern will be delivered to the handler.
	 */
	public function getPattern() : string;

	/**
	 * @throws PacketHandlingException
	 */
	public function handle(AdvancedNetworkInterface $interface, string $address, int $port, string $packet) : bool;
}
