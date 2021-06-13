<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\TreeRoot;
use pocketmine\network\mcpe\protocol\serializer\NetworkNbtSerializer;
use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class AddVolumeEntityPacket extends DataPacket implements ClientboundPacket{
	public const NETWORK_ID = ProtocolInfo::ADD_VOLUME_ENTITY_PACKET;

	/** @var int */
	private $entityNetId;
	/** @var CompoundTag */
	private $data;

	public static function create(int $entityNetId, CompoundTag $data) : self{
		$result = new self;
		$result->entityNetId = $entityNetId;
		$result->data = $data;
		return $result;
	}

	public function getEntityNetId() : int{ return $this->entityNetId; }

	public function getData() : CompoundTag{ return $this->data; }

	protected function decodePayload(PacketSerializer $in) : void{
		$this->entityNetId = $in->getUnsignedVarInt();
		$this->data = $in->getNbtCompoundRoot();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putUnsignedVarInt($this->entityNetId);
		$out->put((new NetworkNbtSerializer())->write(new TreeRoot($this->data)));
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleAddVolumeEntity($this);
	}
}
