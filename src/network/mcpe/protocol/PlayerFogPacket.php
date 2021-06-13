<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;
use function count;

class PlayerFogPacket extends DataPacket implements ClientboundPacket{
	public const NETWORK_ID = ProtocolInfo::PLAYER_FOG_PACKET;

	/**
	 * @var string[]
	 * @phpstan-var list<string>
	 */
	private $fogLayers;

	/**
	 * @param string[] $fogLayers
	 * @phpstan-param list<string> $fogLayers
	 */
	public static function create(array $fogLayers) : self{
		$result = new self;
		$result->fogLayers = $fogLayers;
		return $result;
	}

	/**
	 * @return string[]
	 * @phpstan-return list<string>
	 */
	public function getFogLayers() : array{ return $this->fogLayers; }

	protected function decodePayload(PacketSerializer $in) : void{
		$this->fogLayers = [];
		for($i = 0, $len = $in->getUnsignedVarInt(); $i < $len; ++$i){
			$this->fogLayers[] = $in->getString();
		}
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putUnsignedVarInt(count($this->fogLayers));
		foreach($this->fogLayers as $fogLayer){
			$out->putString($fogLayer);
		}
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handlePlayerFog($this);
	}
}
