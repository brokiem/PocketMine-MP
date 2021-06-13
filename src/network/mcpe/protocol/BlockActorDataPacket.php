<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;
use pocketmine\network\mcpe\protocol\types\CacheableNbt;

class BlockActorDataPacket extends DataPacket implements ClientboundPacket, ServerboundPacket{
	public const NETWORK_ID = ProtocolInfo::BLOCK_ACTOR_DATA_PACKET;

	/** @var int */
	public $x;
	/** @var int */
	public $y;
	/** @var int */
	public $z;
	/**
	 * @var CacheableNbt
	 * @phpstan-var CacheableNbt<\pocketmine\nbt\tag\CompoundTag>
	 */
	public $namedtag;

	/**
	 * @phpstan-param CacheableNbt<\pocketmine\nbt\tag\CompoundTag> $nbt
	 */
	public static function create(int $x, int $y, int $z, CacheableNbt $nbt) : self{
		$result = new self;
		[$result->x, $result->y, $result->z] = [$x, $y, $z];
		$result->namedtag = $nbt;
		return $result;
	}

	protected function decodePayload(PacketSerializer $in) : void{
		$in->getBlockPosition($this->x, $this->y, $this->z);
		$this->namedtag = new CacheableNbt($in->getNbtCompoundRoot());
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putBlockPosition($this->x, $this->y, $this->z);
		$out->put($this->namedtag->getEncodedNbt());
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleBlockActorData($this);
	}
}
