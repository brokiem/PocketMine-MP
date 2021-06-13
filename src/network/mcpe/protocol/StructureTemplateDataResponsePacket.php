<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;
use pocketmine\network\mcpe\protocol\types\CacheableNbt;

class StructureTemplateDataResponsePacket extends DataPacket implements ClientboundPacket{
	public const NETWORK_ID = ProtocolInfo::STRUCTURE_TEMPLATE_DATA_RESPONSE_PACKET;

	/** @var string */
	public $structureTemplateName;
	/**
	 * @var CacheableNbt|null
	 * @phpstan-var CacheableNbt<\pocketmine\nbt\tag\CompoundTag>
	 */
	public $namedtag;

	protected function decodePayload(PacketSerializer $in) : void{
		$this->structureTemplateName = $in->getString();
		if($in->getBool()){
			$this->namedtag = new CacheableNbt($in->getNbtCompoundRoot());
		}
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putString($this->structureTemplateName);
		$out->putBool($this->namedtag !== null);
		if($this->namedtag !== null){
			$out->put($this->namedtag->getEncodedNbt());
		}
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleStructureTemplateDataResponse($this);
	}
}
