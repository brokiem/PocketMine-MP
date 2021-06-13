<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;
use function ord;
use function strlen;

class UnknownPacket extends DataPacket{
	public const NETWORK_ID = -1; //Invalid, do not try to write this

	/** @var string */
	public $payload;

	public function pid() : int{
		if(strlen($this->payload ?? "") > 0){
			return ord($this->payload[0]);
		}
		return self::NETWORK_ID;
	}

	public function getName() : string{
		return "unknown packet";
	}

	protected function decodeHeader(PacketSerializer $in) : void{

	}

	protected function decodePayload(PacketSerializer $in) : void{
		$this->payload = $in->getRemaining();
	}

	protected function encodeHeader(PacketSerializer $out) : void{

	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->put($this->payload);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return false;
	}
}
