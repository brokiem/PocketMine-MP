<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;
use pocketmine\network\mcpe\protocol\types\entity\Attribute;
use function array_values;

class UpdateAttributesPacket extends DataPacket implements ClientboundPacket{
	public const NETWORK_ID = ProtocolInfo::UPDATE_ATTRIBUTES_PACKET;

	/** @var int */
	public $entityRuntimeId;
	/** @var Attribute[] */
	public $entries = [];
	/** @var int */
	public $tick = 0;

	/**
	 * @param Attribute[] $attributes
	 *
	 * @return UpdateAttributesPacket
	 */
	public static function create(int $entityRuntimeId, array $attributes, int $tick) : self{
		$result = new self;
		$result->entityRuntimeId = $entityRuntimeId;
		$result->entries = $attributes;
		$result->tick = $tick;
		return $result;
	}

	protected function decodePayload(PacketSerializer $in) : void{
		$this->entityRuntimeId = $in->getEntityRuntimeId();
		$this->entries = $in->getAttributeList();
		$this->tick = $in->getUnsignedVarLong();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putEntityRuntimeId($this->entityRuntimeId);
		$out->putAttributeList(...array_values($this->entries));
		$out->putUnsignedVarLong($this->tick);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleUpdateAttributes($this);
	}
}
