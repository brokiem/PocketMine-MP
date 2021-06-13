<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class AddPaintingPacket extends DataPacket implements ClientboundPacket{
	public const NETWORK_ID = ProtocolInfo::ADD_PAINTING_PACKET;

	/** @var int|null */
	public $entityUniqueId = null;
	/** @var int */
	public $entityRuntimeId;
	/** @var Vector3 */
	public $position;
	/** @var int */
	public $direction;
	/** @var string */
	public $title;

	protected function decodePayload(PacketSerializer $in) : void{
		$this->entityUniqueId = $in->getEntityUniqueId();
		$this->entityRuntimeId = $in->getEntityRuntimeId();
		$this->position = $in->getVector3();
		$this->direction = $in->getVarInt();
		$this->title = $in->getString();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putEntityUniqueId($this->entityUniqueId ?? $this->entityRuntimeId);
		$out->putEntityRuntimeId($this->entityRuntimeId);
		$out->putVector3($this->position);
		$out->putVarInt($this->direction);
		$out->putString($this->title);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleAddPainting($this);
	}
}
