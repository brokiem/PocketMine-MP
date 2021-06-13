<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class EventPacket extends DataPacket implements ClientboundPacket{
	public const NETWORK_ID = ProtocolInfo::EVENT_PACKET;

	public const TYPE_ACHIEVEMENT_AWARDED = 0;
	public const TYPE_ENTITY_INTERACT = 1;
	public const TYPE_PORTAL_BUILT = 2;
	public const TYPE_PORTAL_USED = 3;
	public const TYPE_MOB_KILLED = 4;
	public const TYPE_CAULDRON_USED = 5;
	public const TYPE_PLAYER_DEATH = 6;
	public const TYPE_BOSS_KILLED = 7;
	public const TYPE_AGENT_COMMAND = 8;
	public const TYPE_AGENT_CREATED = 9;
	public const TYPE_PATTERN_REMOVED = 10; //???
	public const TYPE_COMMANED_EXECUTED = 11;
	public const TYPE_FISH_BUCKETED = 12;
	public const TYPE_MOB_BORN = 13;
	public const TYPE_PET_DIED = 14;
	public const TYPE_CAULDRON_BLOCK_USED = 15;
	public const TYPE_COMPOSTER_BLOCK_USED = 16;
	public const TYPE_BELL_BLOCK_USED = 17;
	public const TYPE_ACTOR_DEFINITION = 18;
	public const TYPE_RAID_UPDATE = 19;
	public const TYPE_PLAYER_MOVEMENT_ANOMALY = 20; //anti cheat
	public const TYPE_PLAYER_MOVEMENT_CORRECTED = 21;
	public const TYPE_HONEY_HARVESTED = 22;
	public const TYPE_TARGET_BLOCK_HIT = 23;
	public const TYPE_PIGLIN_BARTER = 24;

	/** @var int */
	public $playerRuntimeId;
	/** @var int */
	public $eventData;
	/** @var int */
	public $type;

	protected function decodePayload(PacketSerializer $in) : void{
		$this->playerRuntimeId = $in->getEntityRuntimeId();
		$this->eventData = $in->getVarInt();
		$this->type = $in->getByte();

		//TODO: nice confusing mess
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putEntityRuntimeId($this->playerRuntimeId);
		$out->putVarInt($this->eventData);
		$out->putByte($this->type);

		//TODO: also nice confusing mess
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleEvent($this);
	}
}
