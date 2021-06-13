<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;
use pocketmine\network\mcpe\protocol\types\StructureSettings;

class StructureTemplateDataRequestPacket extends DataPacket implements ServerboundPacket{
	public const NETWORK_ID = ProtocolInfo::STRUCTURE_TEMPLATE_DATA_REQUEST_PACKET;

	public const TYPE_ALWAYS_LOAD = 1;
	public const TYPE_CREATE_AND_LOAD = 2;

	/** @var string */
	public $structureTemplateName;
	/** @var int */
	public $structureBlockX;
	/** @var int */
	public $structureBlockY;
	/** @var int */
	public $structureBlockZ;
	/** @var StructureSettings */
	public $structureSettings;
	/** @var int */
	public $structureTemplateResponseType;

	protected function decodePayload(PacketSerializer $in) : void{
		$this->structureTemplateName = $in->getString();
		$in->getBlockPosition($this->structureBlockX, $this->structureBlockY, $this->structureBlockZ);
		$this->structureSettings = $in->getStructureSettings();
		$this->structureTemplateResponseType = $in->getByte();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putString($this->structureTemplateName);
		$out->putBlockPosition($this->structureBlockX, $this->structureBlockY, $this->structureBlockZ);
		$out->putStructureSettings($this->structureSettings);
		$out->putByte($this->structureTemplateResponseType);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleStructureTemplateDataRequest($this);
	}
}
