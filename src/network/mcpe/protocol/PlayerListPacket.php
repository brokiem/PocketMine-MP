<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;
use pocketmine\network\mcpe\protocol\types\PlayerListEntry;
use function count;

class PlayerListPacket extends DataPacket implements ClientboundPacket{
	public const NETWORK_ID = ProtocolInfo::PLAYER_LIST_PACKET;

	public const TYPE_ADD = 0;
	public const TYPE_REMOVE = 1;

	/** @var PlayerListEntry[] */
	public $entries = [];
	/** @var int */
	public $type;

	/**
	 * @param PlayerListEntry[] $entries
	 */
	public static function add(array $entries) : self{
		$result = new self;
		$result->type = self::TYPE_ADD;
		$result->entries = $entries;
		return $result;
	}

	/**
	 * @param PlayerListEntry[] $entries
	 */
	public static function remove(array $entries) : self{
		$result = new self;
		$result->type = self::TYPE_REMOVE;
		$result->entries = $entries;
		return $result;
	}

	protected function decodePayload(PacketSerializer $in) : void{
		$this->type = $in->getByte();
		$count = $in->getUnsignedVarInt();
		for($i = 0; $i < $count; ++$i){
			$entry = new PlayerListEntry();

			if($this->type === self::TYPE_ADD){
				$entry->uuid = $in->getUUID();
				$entry->entityUniqueId = $in->getEntityUniqueId();
				$entry->username = $in->getString();
				$entry->xboxUserId = $in->getString();
				$entry->platformChatId = $in->getString();
				$entry->buildPlatform = $in->getLInt();
				$entry->skinData = $in->getSkin();
				$entry->isTeacher = $in->getBool();
				$entry->isHost = $in->getBool();
			}else{
				$entry->uuid = $in->getUUID();
			}

			$this->entries[$i] = $entry;
		}
		if($this->type === self::TYPE_ADD){
			for($i = 0; $i < $count; ++$i){
				$this->entries[$i]->skinData->setVerified($in->getBool());
			}
		}
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putByte($this->type);
		$out->putUnsignedVarInt(count($this->entries));
		foreach($this->entries as $entry){
			if($this->type === self::TYPE_ADD){
				$out->putUUID($entry->uuid);
				$out->putEntityUniqueId($entry->entityUniqueId);
				$out->putString($entry->username);
				$out->putString($entry->xboxUserId);
				$out->putString($entry->platformChatId);
				$out->putLInt($entry->buildPlatform);
				$out->putSkin($entry->skinData);
				$out->putBool($entry->isTeacher);
				$out->putBool($entry->isHost);
			}else{
				$out->putUUID($entry->uuid);
			}
		}
		if($this->type === self::TYPE_ADD){
			foreach($this->entries as $entry){
				$out->putBool($entry->skinData->isVerified());
			}
		}
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handlePlayerList($this);
	}
}
