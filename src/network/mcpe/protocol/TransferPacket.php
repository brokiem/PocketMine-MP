<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class TransferPacket extends DataPacket implements ClientboundPacket{
	public const NETWORK_ID = ProtocolInfo::TRANSFER_PACKET;

	/** @var string */
	public $address;
	/** @var int */
	public $port = 19132;

	public static function create(string $address, int $port) : self{
		$result = new self;
		$result->address = $address;
		$result->port = $port;
		return $result;
	}

	protected function decodePayload(PacketSerializer $in) : void{
		$this->address = $in->getString();
		$this->port = $in->getLShort();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putString($this->address);
		$out->putLShort($this->port);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleTransfer($this);
	}
}
