<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\nbt\TreeRoot;
use pocketmine\network\mcpe\protocol\serializer\NetworkNbtSerializer;
use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;
use pocketmine\network\mcpe\protocol\types\ItemComponentPacketEntry;
use function count;

class ItemComponentPacket extends DataPacket implements ClientboundPacket{
	public const NETWORK_ID = ProtocolInfo::ITEM_COMPONENT_PACKET;

	/**
	 * @var ItemComponentPacketEntry[]
	 * @phpstan-var list<ItemComponentPacketEntry>
	 */
	private $entries;

	/**
	 * @param ItemComponentPacketEntry[] $entries
	 * @phpstan-param list<ItemComponentPacketEntry> $entries
	 */
	public static function create(array $entries) : self{
		$result = new self;
		$result->entries = $entries;
		return $result;
	}

	/**
	 * @return ItemComponentPacketEntry[]
	 * @phpstan-return list<ItemComponentPacketEntry>
	 */
	public function getEntries() : array{ return $this->entries; }

	protected function decodePayload(PacketSerializer $in) : void{
		$this->entries = [];
		for($i = 0, $len = $in->getUnsignedVarInt(); $i < $len; ++$i){
			$name = $in->getString();
			$nbt = $in->getNbtCompoundRoot();
			$this->entries[] = new ItemComponentPacketEntry($name, $nbt);
		}
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putUnsignedVarInt(count($this->entries));
		foreach($this->entries as $entry){
			$out->putString($entry->getName());
			$out->put((new NetworkNbtSerializer())->write(new TreeRoot($entry->getComponentNbt())));
		}
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleItemComponent($this);
	}
}
