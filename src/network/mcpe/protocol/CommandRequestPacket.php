<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;
use pocketmine\network\mcpe\protocol\types\command\CommandOriginData;

class CommandRequestPacket extends DataPacket implements ServerboundPacket{
	public const NETWORK_ID = ProtocolInfo::COMMAND_REQUEST_PACKET;

	/** @var string */
	public $command;
	/** @var CommandOriginData */
	public $originData;
	/** @var bool */
	public $isInternal;

	protected function decodePayload(PacketSerializer $in) : void{
		$this->command = $in->getString();
		$this->originData = $in->getCommandOriginData();
		$this->isInternal = $in->getBool();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putString($this->command);
		$out->putCommandOriginData($this->originData);
		$out->putBool($this->isInternal);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleCommandRequest($this);
	}
}
