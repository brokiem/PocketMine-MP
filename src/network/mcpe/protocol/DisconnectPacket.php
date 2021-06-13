<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class DisconnectPacket extends DataPacket implements ClientboundPacket, ServerboundPacket{
	public const NETWORK_ID = ProtocolInfo::DISCONNECT_PACKET;

	/** @var bool */
	public $hideDisconnectionScreen = false;
	/** @var string */
	public $message = "";

	public static function silent() : self{
		$result = new self;
		$result->hideDisconnectionScreen = true;
		return $result;
	}

	public static function message(string $message) : self{
		$result = new self;
		$result->hideDisconnectionScreen = false;
		$result->message = $message;
		return $result;
	}

	public function canBeSentBeforeLogin() : bool{
		return true;
	}

	protected function decodePayload(PacketSerializer $in) : void{
		$this->hideDisconnectionScreen = $in->getBool();
		if(!$this->hideDisconnectionScreen){
			$this->message = $in->getString();
		}
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putBool($this->hideDisconnectionScreen);
		if(!$this->hideDisconnectionScreen){
			$out->putString($this->message);
		}
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleDisconnect($this);
	}
}
