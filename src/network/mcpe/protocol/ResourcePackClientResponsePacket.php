<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;
use function count;

class ResourcePackClientResponsePacket extends DataPacket implements ServerboundPacket{
	public const NETWORK_ID = ProtocolInfo::RESOURCE_PACK_CLIENT_RESPONSE_PACKET;

	public const STATUS_REFUSED = 1;
	public const STATUS_SEND_PACKS = 2;
	public const STATUS_HAVE_ALL_PACKS = 3;
	public const STATUS_COMPLETED = 4;

	/** @var int */
	public $status;
	/** @var string[] */
	public $packIds = [];

	protected function decodePayload(PacketSerializer $in) : void{
		$this->status = $in->getByte();
		$entryCount = $in->getLShort();
		$this->packIds = [];
		while($entryCount-- > 0){
			$this->packIds[] = $in->getString();
		}
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putByte($this->status);
		$out->putLShort(count($this->packIds));
		foreach($this->packIds as $id){
			$out->putString($id);
		}
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleResourcePackClientResponse($this);
	}
}
