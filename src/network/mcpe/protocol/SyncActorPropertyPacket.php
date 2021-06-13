<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\TreeRoot;
use pocketmine\network\mcpe\protocol\serializer\NetworkNbtSerializer;
use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class SyncActorPropertyPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::SYNC_ACTOR_PROPERTY_PACKET;

	/** @var CompoundTag */
	private $data;

	public static function create(CompoundTag $data) : self{
		$result = new self;
		$result->data = $data;
		return $result;
	}

	public function getData() : CompoundTag{ return $this->data; }

	protected function decodePayload(PacketSerializer $in) : void{
		$this->data = $in->getNbtCompoundRoot();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->put((new NetworkNbtSerializer())->write(new TreeRoot($this->data)));
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleSyncActorProperty($this);
	}
}
