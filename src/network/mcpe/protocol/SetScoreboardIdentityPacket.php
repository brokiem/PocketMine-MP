<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;
use pocketmine\network\mcpe\protocol\types\ScoreboardIdentityPacketEntry;
use function count;

class SetScoreboardIdentityPacket extends DataPacket implements ClientboundPacket{
	public const NETWORK_ID = ProtocolInfo::SET_SCOREBOARD_IDENTITY_PACKET;

	public const TYPE_REGISTER_IDENTITY = 0;
	public const TYPE_CLEAR_IDENTITY = 1;

	/** @var int */
	public $type;
	/** @var ScoreboardIdentityPacketEntry[] */
	public $entries = [];

	protected function decodePayload(PacketSerializer $in) : void{
		$this->type = $in->getByte();
		for($i = 0, $count = $in->getUnsignedVarInt(); $i < $count; ++$i){
			$entry = new ScoreboardIdentityPacketEntry();
			$entry->scoreboardId = $in->getVarLong();
			if($this->type === self::TYPE_REGISTER_IDENTITY){
				$entry->entityUniqueId = $in->getEntityUniqueId();
			}

			$this->entries[] = $entry;
		}
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putByte($this->type);
		$out->putUnsignedVarInt(count($this->entries));
		foreach($this->entries as $entry){
			$out->putVarLong($entry->scoreboardId);
			if($this->type === self::TYPE_REGISTER_IDENTITY){
				$out->putEntityUniqueId($entry->entityUniqueId);
			}
		}
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleSetScoreboardIdentity($this);
	}
}
