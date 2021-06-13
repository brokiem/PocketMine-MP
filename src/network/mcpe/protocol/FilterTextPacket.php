<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class FilterTextPacket extends DataPacket implements ClientboundPacket, ServerboundPacket{
	public const NETWORK_ID = ProtocolInfo::FILTER_TEXT_PACKET;

	/** @var string */
	private $text;
	/** @var bool */
	private $fromServer;

	public static function create(string $text, bool $server) : self{
		$result = new self;
		$result->text = $text;
		$result->fromServer = $server;
		return $result;
	}

	public function getText() : string{ return $this->text; }

	public function isFromServer() : bool{ return $this->fromServer; }

	protected function decodePayload(PacketSerializer $in) : void{
		$this->text = $in->getString();
		$this->fromServer = $in->getBool();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putString($this->text);
		$out->putBool($this->fromServer);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleFilterText($this);
	}
}
