<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe;

interface PacketSender{

	/**
	 * Pushes a packet into the channel to be processed.
	 */
	public function send(string $payload, bool $immediate) : void;

	/**
	 * Closes the channel, terminating the connection.
	 */
	public function close(string $reason = "unknown reason") : void;
}
