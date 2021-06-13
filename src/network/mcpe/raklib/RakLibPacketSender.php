<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\raklib;

use pocketmine\network\mcpe\PacketSender;

class RakLibPacketSender implements PacketSender{

	/** @var int */
	private $sessionId;
	/** @var RakLibInterface */
	private $handler;

	/** @var bool */
	private $closed = false;

	public function __construct(int $sessionId, RakLibInterface $handler){
		$this->sessionId = $sessionId;
		$this->handler = $handler;
	}

	public function send(string $payload, bool $immediate) : void{
		if(!$this->closed){
			$this->handler->putPacket($this->sessionId, $payload, $immediate);
		}
	}

	public function close(string $reason = "unknown reason") : void{
		if(!$this->closed){
			$this->closed = true;
			$this->handler->close($this->sessionId);
		}
	}
}
