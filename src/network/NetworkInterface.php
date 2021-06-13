<?php

declare(strict_types=1);

/**
 * Network-related classes
 */
namespace pocketmine\network;

/**
 * Network interfaces are transport layers which can be used to transmit packets between the server and clients.
 */
interface NetworkInterface{

	/**
	 * Performs actions needed to start the interface after it is registered.
	 */
	public function start() : void;

	public function setName(string $name) : void;

	/**
	 * Called every tick to process events on the interface.
	 */
	public function tick() : void;

	/**
	 * Gracefully shuts down the network interface.
	 */
	public function shutdown() : void;
}
