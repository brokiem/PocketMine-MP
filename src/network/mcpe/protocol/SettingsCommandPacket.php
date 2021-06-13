<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class SettingsCommandPacket extends DataPacket implements ServerboundPacket{
	public const NETWORK_ID = ProtocolInfo::SETTINGS_COMMAND_PACKET;

	/** @var string */
	private $command;
	/** @var bool */
	private $suppressOutput;

	public static function create(string $command, bool $suppressOutput) : self{
		$result = new self;
		$result->command = $command;
		$result->suppressOutput = $suppressOutput;
		return $result;
	}

	public function getCommand() : string{
		return $this->command;
	}

	public function getSuppressOutput() : bool{
		return $this->suppressOutput;
	}

	protected function decodePayload(PacketSerializer $in) : void{
		$this->command = $in->getString();
		$this->suppressOutput = $in->getBool();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putString($this->command);
		$out->putBool($this->suppressOutput);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleSettingsCommand($this);
	}
}
