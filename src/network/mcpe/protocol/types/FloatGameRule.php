<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types;

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

final class FloatGameRule extends GameRule{
	/** @var float */
	private $value;

	public function __construct(float $value, bool $isPlayerModifiable){
		parent::__construct($isPlayerModifiable);
		$this->value = $value;
	}

	public function getType() : int{
		return GameRuleType::FLOAT;
	}

	public function getValue() : float{
		return $this->value;
	}

	public function encode(PacketSerializer $out) : void{
		$out->putLFloat($this->value);
	}

	public static function decode(PacketSerializer $in, bool $isPlayerModifiable) : self{
		return new self($in->getLFloat(), $isPlayerModifiable);
	}
}
