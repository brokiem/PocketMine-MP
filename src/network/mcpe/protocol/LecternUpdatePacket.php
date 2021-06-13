<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class LecternUpdatePacket extends DataPacket implements ServerboundPacket{
	public const NETWORK_ID = ProtocolInfo::LECTERN_UPDATE_PACKET;

	/** @var int */
	public $page;
	/** @var int */
	public $totalPages;
	/** @var int */
	public $x;
	/** @var int */
	public $y;
	/** @var int */
	public $z;
	/** @var bool */
	public $dropBook;

	protected function decodePayload(PacketSerializer $in) : void{
		$this->page = $in->getByte();
		$this->totalPages = $in->getByte();
		$in->getBlockPosition($this->x, $this->y, $this->z);
		$this->dropBook = $in->getBool();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putByte($this->page);
		$out->putByte($this->totalPages);
		$out->putBlockPosition($this->x, $this->y, $this->z);
		$out->putBool($this->dropBook);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleLecternUpdate($this);
	}
}
