<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;
use pocketmine\network\mcpe\protocol\types\CacheableNbt;

class BiomeDefinitionListPacket extends DataPacket implements ClientboundPacket{
	public const NETWORK_ID = ProtocolInfo::BIOME_DEFINITION_LIST_PACKET;

	/**
	 * @var CacheableNbt
	 * @phpstan-var CacheableNbt<\pocketmine\nbt\tag\CompoundTag>
	 */
	public $defs;

	/**
	 * @phpstan-param CacheableNbt<\pocketmine\nbt\tag\CompoundTag> $nbt
	 */
	public static function create(CacheableNbt $nbt) : self{
		$result = new self;
		$result->defs = $nbt;
		return $result;
	}

	protected function decodePayload(PacketSerializer $in) : void{
		$this->defs = new CacheableNbt($in->getNbtCompoundRoot());
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->put($this->defs->getEncodedNbt());
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleBiomeDefinitionList($this);
	}
}
