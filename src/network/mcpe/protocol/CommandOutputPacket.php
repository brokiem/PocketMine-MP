<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;
use pocketmine\network\mcpe\protocol\types\command\CommandOriginData;
use pocketmine\network\mcpe\protocol\types\command\CommandOutputMessage;
use pocketmine\utils\BinaryDataException;
use function count;

class CommandOutputPacket extends DataPacket implements ClientboundPacket{
	public const NETWORK_ID = ProtocolInfo::COMMAND_OUTPUT_PACKET;

	public const TYPE_LAST = 1;
	public const TYPE_SILENT = 2;
	public const TYPE_ALL = 3;
	public const TYPE_DATA_SET = 4;

	/** @var CommandOriginData */
	public $originData;
	/** @var int */
	public $outputType;
	/** @var int */
	public $successCount;
	/** @var CommandOutputMessage[] */
	public $messages = [];
	/** @var string */
	public $unknownString;

	protected function decodePayload(PacketSerializer $in) : void{
		$this->originData = $in->getCommandOriginData();
		$this->outputType = $in->getByte();
		$this->successCount = $in->getUnsignedVarInt();

		for($i = 0, $size = $in->getUnsignedVarInt(); $i < $size; ++$i){
			$this->messages[] = $this->getCommandMessage($in);
		}

		if($this->outputType === self::TYPE_DATA_SET){
			$this->unknownString = $in->getString();
		}
	}

	/**
	 * @throws BinaryDataException
	 */
	protected function getCommandMessage(PacketSerializer $in) : CommandOutputMessage{
		$message = new CommandOutputMessage();

		$message->isInternal = $in->getBool();
		$message->messageId = $in->getString();

		for($i = 0, $size = $in->getUnsignedVarInt(); $i < $size; ++$i){
			$message->parameters[] = $in->getString();
		}

		return $message;
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putCommandOriginData($this->originData);
		$out->putByte($this->outputType);
		$out->putUnsignedVarInt($this->successCount);

		$out->putUnsignedVarInt(count($this->messages));
		foreach($this->messages as $message){
			$this->putCommandMessage($message, $out);
		}

		if($this->outputType === self::TYPE_DATA_SET){
			$out->putString($this->unknownString);
		}
	}

	protected function putCommandMessage(CommandOutputMessage $message, PacketSerializer $out) : void{
		$out->putBool($message->isInternal);
		$out->putString($message->messageId);

		$out->putUnsignedVarInt(count($message->parameters));
		foreach($message->parameters as $parameter){
			$out->putString($parameter);
		}
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleCommandOutput($this);
	}
}
