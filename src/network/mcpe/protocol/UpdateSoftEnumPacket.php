<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;
use function count;

class UpdateSoftEnumPacket extends DataPacket implements ClientboundPacket{
	public const NETWORK_ID = ProtocolInfo::UPDATE_SOFT_ENUM_PACKET;

	public const TYPE_ADD = 0;
	public const TYPE_REMOVE = 1;
	public const TYPE_SET = 2;

	/** @var string */
	public $enumName;
	/** @var string[] */
	public $values = [];
	/** @var int */
	public $type;

	protected function decodePayload(PacketSerializer $in) : void{
		$this->enumName = $in->getString();
		for($i = 0, $count = $in->getUnsignedVarInt(); $i < $count; ++$i){
			$this->values[] = $in->getString();
		}
		$this->type = $in->getByte();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putString($this->enumName);
		$out->putUnsignedVarInt(count($this->values));
		foreach($this->values as $v){
			$out->putString($v);
		}
		$out->putByte($this->type);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleUpdateSoftEnum($this);
	}
}
