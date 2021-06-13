<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\nbt\tag\CompoundTag;
use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;
use pocketmine\network\mcpe\protocol\types\CacheableNbt;

class LevelEventGenericPacket extends DataPacket implements ClientboundPacket{
	public const NETWORK_ID = ProtocolInfo::LEVEL_EVENT_GENERIC_PACKET;

	/** @var int */
	private $eventId;
	/**
	 * @var CacheableNbt
	 * @phpstan-var CacheableNbt<\pocketmine\nbt\tag\CompoundTag>
	 */
	private $eventData;

	public static function create(int $eventId, CompoundTag $data) : self{
		$result = new self;
		$result->eventId = $eventId;
		$result->eventData = new CacheableNbt($data);
		return $result;
	}

	public function getEventId() : int{
		return $this->eventId;
	}

	/**
	 * @phpstan-return CacheableNbt<\pocketmine\nbt\tag\CompoundTag>
	 */
	public function getEventData() : CacheableNbt{
		return $this->eventData;
	}

	protected function decodePayload(PacketSerializer $in) : void{
		$this->eventId = $in->getVarInt();
		$this->eventData = new CacheableNbt($in->getNbtCompoundRoot());
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putVarInt($this->eventId);
		$out->put($this->eventData->getEncodedNbt());
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleLevelEventGeneric($this);
	}
}
