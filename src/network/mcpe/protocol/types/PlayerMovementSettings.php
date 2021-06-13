<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types;

use pocketmine\network\mcpe\protocol\ProtocolInfo;
use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

final class PlayerMovementSettings{
	/** @var int */
	private $movementType;
	/** @var int */
	private $rewindHistorySize;
	/** @var bool */
	private $serverAuthoritativeBlockBreaking;

	public function __construct(int $movementType, int $rewindHistorySize, bool $serverAuthoritativeBlockBreaking){
		$this->movementType = $movementType;
		$this->rewindHistorySize = $rewindHistorySize;
		//do not ask me what the F this is doing here
		$this->serverAuthoritativeBlockBreaking = $serverAuthoritativeBlockBreaking;
	}

	public function getMovementType() : int{ return $this->movementType; }

	public function getRewindHistorySize() : int{ return $this->rewindHistorySize; }

	public function isServerAuthoritativeBlockBreaking() : bool{ return $this->serverAuthoritativeBlockBreaking; }

	public static function read(PacketSerializer $in) : self{
		$movementType = $in->getVarInt();
		if($in->getProtocolId() >= ProtocolInfo::PROTOCOL_1_16_210_57){
			$rewindHistorySize = $in->getVarInt();
			$serverAuthBlockBreaking = $in->getBool();
		}
		return new self($movementType, $rewindHistorySize ?? 0, $serverAuthBlockBreaking ?? false);
	}

	public function write(PacketSerializer $out) : void{
		$out->putVarInt($this->movementType);
		if($out->getProtocolId() >= ProtocolInfo::PROTOCOL_1_16_210_57){
			$out->putVarInt($this->rewindHistorySize);
			$out->putBool($this->serverAuthoritativeBlockBreaking);
		}
	}
}
