<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class ModalFormRequestPacket extends DataPacket implements ClientboundPacket{
	public const NETWORK_ID = ProtocolInfo::MODAL_FORM_REQUEST_PACKET;

	/** @var int */
	public $formId;
	/** @var string */
	public $formData; //json

	public static function create(int $formId, string $formData) : self{
		$result = new self;
		$result->formId = $formId;
		$result->formData = $formData;
		return $result;
	}

	protected function decodePayload(PacketSerializer $in) : void{
		$this->formId = $in->getUnsignedVarInt();
		$this->formData = $in->getString();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putUnsignedVarInt($this->formId);
		$out->putString($this->formData);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleModalFormRequest($this);
	}
}
