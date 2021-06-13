<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\handler;

use pocketmine\network\mcpe\protocol\SetLocalPlayerAsInitializedPacket;

final class SpawnResponsePacketHandler extends PacketHandler{

	/**
	 * @var \Closure
	 * @phpstan-var \Closure() : void
	 */
	private $responseCallback;

	/**
	 * @phpstan-param \Closure() : void $responseCallback
	 */
	public function __construct(\Closure $responseCallback){
		$this->responseCallback = $responseCallback;
	}

	public function handleSetLocalPlayerAsInitialized(SetLocalPlayerAsInitializedPacket $packet) : bool{
		($this->responseCallback)();
		return true;
	}
}
