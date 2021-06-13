<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class NpcRequestPacket extends DataPacket implements ServerboundPacket{
	public const NETWORK_ID = ProtocolInfo::NPC_REQUEST_PACKET;

	public const REQUEST_SET_ACTIONS = 0;
	public const REQUEST_EXECUTE_ACTION = 1;
	public const REQUEST_EXECUTE_CLOSING_COMMANDS = 2;
	public const REQUEST_SET_NAME = 3;
	public const REQUEST_SET_SKIN = 4;
	public const REQUEST_SET_INTERACTION_TEXT = 5;

	/** @var int */
	public $entityRuntimeId;
	/** @var int */
	public $requestType;
	/** @var string */
	public $commandString;
	/** @var int */
	public $actionType;

	protected function decodePayload(PacketSerializer $in) : void{
		$this->entityRuntimeId = $in->getEntityRuntimeId();
		$this->requestType = $in->getByte();
		$this->commandString = $in->getString();
		$this->actionType = $in->getByte();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putEntityRuntimeId($this->entityRuntimeId);
		$out->putByte($this->requestType);
		$out->putString($this->commandString);
		$out->putByte($this->actionType);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleNpcRequest($this);
	}
}
