<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class PhotoTransferPacket extends DataPacket implements ClientboundPacket{
	public const NETWORK_ID = ProtocolInfo::PHOTO_TRANSFER_PACKET;

	/** @var string */
	public $photoName;
	/** @var string */
	public $photoData;
	/** @var string */
	public $bookId; //photos are stored in a sibling directory to the games folder (screenshots/(some UUID)/bookID/example.png)

	protected function decodePayload(PacketSerializer $in) : void{
		$this->photoName = $in->getString();
		$this->photoData = $in->getString();
		$this->bookId = $in->getString();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putString($this->photoName);
		$out->putString($this->photoData);
		$out->putString($this->bookId);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handlePhotoTransfer($this);
	}
}
