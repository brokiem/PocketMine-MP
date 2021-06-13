<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class TickSyncPacket extends DataPacket implements ClientboundPacket, ServerboundPacket{
	public const NETWORK_ID = ProtocolInfo::TICK_SYNC_PACKET;

	/** @var int */
	private $clientSendTime;
	/** @var int */
	private $serverReceiveTime;

	public static function request(int $clientTime) : self{
		$result = new self;
		$result->clientSendTime = $clientTime;
		$result->serverReceiveTime = 0; //useless
		return $result;
	}

	public static function response(int $clientSendTime, int $serverReceiveTime) : self{
		$result = new self;
		$result->clientSendTime = $clientSendTime;
		$result->serverReceiveTime = $serverReceiveTime;
		return $result;
	}

	public function getClientSendTime() : int{
		return $this->clientSendTime;
	}

	public function getServerReceiveTime() : int{
		return $this->serverReceiveTime;
	}

	protected function decodePayload(PacketSerializer $in) : void{
		$this->clientSendTime = $in->getLLong();
		$this->serverReceiveTime = $in->getLLong();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putLLong($this->clientSendTime);
		$out->putLLong($this->serverReceiveTime);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleTickSync($this);
	}
}
