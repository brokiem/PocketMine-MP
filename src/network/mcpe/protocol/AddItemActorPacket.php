<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;
use pocketmine\network\mcpe\protocol\types\entity\MetadataProperty;
use pocketmine\network\mcpe\protocol\types\inventory\ItemStackWrapper;

class AddItemActorPacket extends DataPacket implements ClientboundPacket{
	public const NETWORK_ID = ProtocolInfo::ADD_ITEM_ACTOR_PACKET;

	/** @var int|null */
	public $entityUniqueId = null; //TODO
	/** @var int */
	public $entityRuntimeId;
	/** @var ItemStackWrapper */
	public $item;
	/** @var Vector3 */
	public $position;
	/** @var Vector3|null */
	public $motion;
	/**
	 * @var MetadataProperty[]
	 * @phpstan-var array<int, MetadataProperty>
	 */
	public $metadata = [];
	/** @var bool */
	public $isFromFishing = false;

	protected function decodePayload(PacketSerializer $in) : void{
		$this->entityUniqueId = $in->getEntityUniqueId();
		$this->entityRuntimeId = $in->getEntityRuntimeId();
		if($in->getProtocolId() >= ProtocolInfo::PROTOCOL_1_16_220){
			$this->item = ItemStackWrapper::read($in);
		}else{
			$this->item = ItemStackWrapper::legacy($in->getItemStackWithoutStackId());
		}
		$this->position = $in->getVector3();
		$this->motion = $in->getVector3();
		$this->metadata = $in->getEntityMetadata();
		$this->isFromFishing = $in->getBool();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putEntityUniqueId($this->entityUniqueId ?? $this->entityRuntimeId);
		$out->putEntityRuntimeId($this->entityRuntimeId);
		if($out->getProtocolId() >= ProtocolInfo::PROTOCOL_1_16_220){
			$this->item->write($out);
		}else{
			$out->putItemStackWithoutStackId($this->item->getItemStack());
		}
		$out->putVector3($this->position);
		$out->putVector3Nullable($this->motion);
		$out->putEntityMetadata($this->metadata);
		$out->putBool($this->isFromFishing);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleAddItemActor($this);
	}
}
