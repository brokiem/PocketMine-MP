<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;
use Ramsey\Uuid\UuidInterface;
use function count;

class EmoteListPacket extends DataPacket implements ClientboundPacket, ServerboundPacket{
	public const NETWORK_ID = ProtocolInfo::EMOTE_LIST_PACKET;

	/** @var int */
	private $playerEntityRuntimeId;
	/** @var UuidInterface[] */
	private $emoteIds;

	/**
	 * @param UuidInterface[] $emoteIds
	 */
	public static function create(int $playerEntityRuntimeId, array $emoteIds) : self{
		$result = new self;
		$result->playerEntityRuntimeId = $playerEntityRuntimeId;
		$result->emoteIds = $emoteIds;
		return $result;
	}

	public function getPlayerEntityRuntimeId() : int{ return $this->playerEntityRuntimeId; }

	/** @return UuidInterface[] */
	public function getEmoteIds() : array{ return $this->emoteIds; }

	protected function decodePayload(PacketSerializer $in) : void{
		$this->playerEntityRuntimeId = $in->getEntityRuntimeId();
		$this->emoteIds = [];
		for($i = 0, $len = $in->getUnsignedVarInt(); $i < $len; ++$i){
			$this->emoteIds[] = $in->getUUID();
		}
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putEntityRuntimeId($this->playerEntityRuntimeId);
		$out->putUnsignedVarInt(count($this->emoteIds));
		foreach($this->emoteIds as $emoteId){
			$out->putUUID($emoteId);
		}
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleEmoteList($this);
	}
}
