<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;
use pocketmine\network\mcpe\protocol\types\entity\MetadataProperty;

class SetActorDataPacket extends DataPacket implements ClientboundPacket, ServerboundPacket{ //TODO: check why this is serverbound
	public const NETWORK_ID = ProtocolInfo::SET_ACTOR_DATA_PACKET;

	/** @var int */
	public $entityRuntimeId;
	/**
	 * @var MetadataProperty[]
	 * @phpstan-var array<int, MetadataProperty>
	 */
	public $metadata;

	/** @var int */
	public $tick = 0;

	/**
	 * @param MetadataProperty[] $metadata
	 * @phpstan-param array<int, MetadataProperty> $metadata
	 */
	public static function create(int $entityRuntimeId, array $metadata, int $tick) : self{

		$result = new self;
		$result->entityRuntimeId = $entityRuntimeId;
		$result->metadata = $metadata;
		$result->tick = $tick;
		return $result;
	}

	protected function decodePayload(PacketSerializer $in) : void{
		$this->entityRuntimeId = $in->getEntityRuntimeId();
		$this->metadata = $in->getEntityMetadata();
		$this->tick = $in->getUnsignedVarLong();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putEntityRuntimeId($this->entityRuntimeId);
		$out->putEntityMetadata($this->metadata);
		$out->putUnsignedVarLong($this->tick);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleSetActorData($this);
	}
}
