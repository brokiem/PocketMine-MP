<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\handler;

use pocketmine\network\mcpe\protocol\ClientToServerHandshakePacket;

/**
 * Handler responsible for awaiting client response from crypto handshake.
 */
class HandshakePacketHandler extends PacketHandler{

	/**
	 * @var \Closure
	 * @phpstan-var \Closure() : void
	 */
	private $onHandshakeCompleted;

	/**
	 * @phpstan-param \Closure() : void $onHandshakeCompleted
	 */
	public function __construct(\Closure $onHandshakeCompleted){
		$this->onHandshakeCompleted = $onHandshakeCompleted;
	}

	public function handleClientToServerHandshake(ClientToServerHandshakePacket $packet) : bool{
		($this->onHandshakeCompleted)();
		return true;
	}
}
