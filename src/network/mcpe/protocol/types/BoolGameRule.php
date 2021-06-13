<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types;

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

final class BoolGameRule extends GameRule{

	/** @var bool */
	private $value;

	public function __construct(bool $value, bool $isPlayerModifiable){
		parent::__construct($isPlayerModifiable);
		$this->value = $value;
	}

	public function getType() : int{
		return GameRuleType::BOOL;
	}

	public function getValue() : bool{
		return $this->value;
	}

	public function encode(PacketSerializer $out) : void{
		$out->putBool($this->value);
	}

	public static function decode(PacketSerializer $in, bool $isPlayerModifiable) : self{
		return new self($in->getBool(), $isPlayerModifiable);
	}
}
