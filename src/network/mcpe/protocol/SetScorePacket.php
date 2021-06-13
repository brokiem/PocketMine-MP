<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;
use pocketmine\network\mcpe\protocol\types\ScorePacketEntry;
use function count;

class SetScorePacket extends DataPacket implements ClientboundPacket{
	public const NETWORK_ID = ProtocolInfo::SET_SCORE_PACKET;

	public const TYPE_CHANGE = 0;
	public const TYPE_REMOVE = 1;

	/** @var int */
	public $type;
	/** @var ScorePacketEntry[] */
	public $entries = [];

	protected function decodePayload(PacketSerializer $in) : void{
		$this->type = $in->getByte();
		for($i = 0, $i2 = $in->getUnsignedVarInt(); $i < $i2; ++$i){
			$entry = new ScorePacketEntry();
			$entry->scoreboardId = $in->getVarLong();
			$entry->objectiveName = $in->getString();
			$entry->score = $in->getLInt();
			if($this->type !== self::TYPE_REMOVE){
				$entry->type = $in->getByte();
				switch($entry->type){
					case ScorePacketEntry::TYPE_PLAYER:
					case ScorePacketEntry::TYPE_ENTITY:
						$entry->entityUniqueId = $in->getEntityUniqueId();
						break;
					case ScorePacketEntry::TYPE_FAKE_PLAYER:
						$entry->customName = $in->getString();
						break;
					default:
						throw new PacketDecodeException("Unknown entry type $entry->type");
				}
			}
			$this->entries[] = $entry;
		}
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putByte($this->type);
		$out->putUnsignedVarInt(count($this->entries));
		foreach($this->entries as $entry){
			$out->putVarLong($entry->scoreboardId);
			$out->putString($entry->objectiveName);
			$out->putLInt($entry->score);
			if($this->type !== self::TYPE_REMOVE){
				$out->putByte($entry->type);
				switch($entry->type){
					case ScorePacketEntry::TYPE_PLAYER:
					case ScorePacketEntry::TYPE_ENTITY:
						$out->putEntityUniqueId($entry->entityUniqueId);
						break;
					case ScorePacketEntry::TYPE_FAKE_PLAYER:
						$out->putString($entry->customName);
						break;
					default:
						throw new \InvalidArgumentException("Unknown entry type $entry->type");
				}
			}
		}
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleSetScore($this);
	}
}
