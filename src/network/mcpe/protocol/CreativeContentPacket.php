<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;
use pocketmine\network\mcpe\protocol\types\inventory\CreativeContentEntry;
use function count;

class CreativeContentPacket extends DataPacket implements ClientboundPacket{
	public const NETWORK_ID = ProtocolInfo::CREATIVE_CONTENT_PACKET;

	/** @var CreativeContentEntry[] */
	private $entries;

	/**
	 * @param CreativeContentEntry[] $entries
	 */
	public static function create(array $entries) : self{
		$result = new self;
		$result->entries = $entries;
		return $result;
	}

	/** @return CreativeContentEntry[] */
	public function getEntries() : array{ return $this->entries; }

	protected function decodePayload(PacketSerializer $in) : void{
		$this->entries = [];
		for($i = 0, $len = $in->getUnsignedVarInt(); $i < $len; ++$i){
			$this->entries[] = CreativeContentEntry::read($in);
		}
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putUnsignedVarInt(count($this->entries));
		foreach($this->entries as $entry){
			$entry->write($out);
		}
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleCreativeContent($this);
	}
}
