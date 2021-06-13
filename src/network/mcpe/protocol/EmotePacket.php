<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class EmotePacket extends DataPacket implements ClientboundPacket, ServerboundPacket{
	public const NETWORK_ID = ProtocolInfo::EMOTE_PACKET;

	public const FLAG_SERVER = 1 << 0;

	/** @var int */
	private $entityRuntimeId;
	/** @var string */
	private $emoteId;
	/** @var int */
	private $flags;

	public static function create(int $entityRuntimeId, string $emoteId, int $flags) : self{
		$result = new self;
		$result->entityRuntimeId = $entityRuntimeId;
		$result->emoteId = $emoteId;
		$result->flags = $flags;
		return $result;
	}

	/**
	 * TODO: we can't call this getEntityRuntimeId() because of base class collision (crap architecture, thanks Shoghi)
	 */
	public function getEntityRuntimeIdField() : int{
		return $this->entityRuntimeId;
	}

	public function getEmoteId() : string{
		return $this->emoteId;
	}

	public function getFlags() : int{
		return $this->flags;
	}

	protected function decodePayload(PacketSerializer $in) : void{
		$this->entityRuntimeId = $in->getEntityRuntimeId();
		$this->emoteId = $in->getString();
		$this->flags = $in->getByte();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putEntityRuntimeId($this->entityRuntimeId);
		$out->putString($this->emoteId);
		$out->putByte($this->flags);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleEmote($this);
	}
}
