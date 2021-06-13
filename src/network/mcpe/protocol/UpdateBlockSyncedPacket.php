<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class UpdateBlockSyncedPacket extends UpdateBlockPacket{
	public const NETWORK_ID = ProtocolInfo::UPDATE_BLOCK_SYNCED_PACKET;

	public const TYPE_NONE = 0;
	public const TYPE_CREATE = 1;
	public const TYPE_DESTROY = 2;

	/** @var int */
	public $entityUniqueId;
	/** @var int */
	public $updateType;

	protected function decodePayload(PacketSerializer $in) : void{
		parent::decodePayload($in);
		$this->entityUniqueId = $in->getUnsignedVarLong();
		$this->updateType = $in->getUnsignedVarLong();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		parent::encodePayload($out);
		$out->putUnsignedVarLong($this->entityUniqueId);
		$out->putUnsignedVarLong($this->updateType);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleUpdateBlockSynced($this);
	}
}
