<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;
use pocketmine\network\mcpe\protocol\types\StructureEditorData;

class StructureBlockUpdatePacket extends DataPacket implements ServerboundPacket{
	public const NETWORK_ID = ProtocolInfo::STRUCTURE_BLOCK_UPDATE_PACKET;

	/** @var int */
	public $x;
	/** @var int */
	public $y;
	/** @var int */
	public $z;
	/** @var StructureEditorData */
	public $structureEditorData;
	/** @var bool */
	public $isPowered;

	protected function decodePayload(PacketSerializer $in) : void{
		$in->getBlockPosition($this->x, $this->y, $this->z);
		$this->structureEditorData = $in->getStructureEditorData();
		$this->isPowered = $in->getBool();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putBlockPosition($this->x, $this->y, $this->z);
		$out->putStructureEditorData($this->structureEditorData);
		$out->putBool($this->isPowered);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleStructureBlockUpdate($this);
	}
}
