<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types;

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

final class IntGameRule extends GameRule{

	/** @var int */
	private $value;

	public function __construct(int $value, bool $isPlayerModifiable){
		parent::__construct($isPlayerModifiable);
		$this->value = $value;
	}

	public function getType() : int{
		return GameRuleType::INT;
	}

	public function getValue() : int{
		return $this->value;
	}

	public function encode(PacketSerializer $out) : void{
		$out->putUnsignedVarInt($this->value);
	}

	public static function decode(PacketSerializer $in, bool $isPlayerModifiable) : self{
		return new self($in->getUnsignedVarInt(), $isPlayerModifiable);
	}
}
