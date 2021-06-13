<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class CodeBuilderPacket extends DataPacket implements ClientboundPacket{
	public const NETWORK_ID = ProtocolInfo::CODE_BUILDER_PACKET;

	/** @var string */
	private $url;
	/** @var bool */
	private $openCodeBuilder;

	public static function create(string $url, bool $openCodeBuilder) : self{
		$result = new self;
		$result->url = $url;
		$result->openCodeBuilder = $openCodeBuilder;
		return $result;
	}

	public function getUrl() : string{
		return $this->url;
	}

	public function openCodeBuilder() : bool{
		return $this->openCodeBuilder;
	}

	protected function decodePayload(PacketSerializer $in) : void{
		$this->url = $in->getString();
		$this->openCodeBuilder = $in->getBool();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putString($this->url);
		$out->putBool($this->openCodeBuilder);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleCodeBuilder($this);
	}
}
