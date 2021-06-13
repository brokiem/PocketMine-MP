<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types\entity;

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

final class FloatMetadataProperty implements MetadataProperty{

	/** @var float */
	private $value;

	public function __construct(float $value){
		$this->value = $value;
	}

	public function getValue() : float{
		return $this->value;
	}

	public static function id() : int{
		return EntityMetadataTypes::FLOAT;
	}

	public function equals(MetadataProperty $other) : bool{
		return $other instanceof self and $other->value === $this->value;
	}

	public static function read(PacketSerializer $in) : self{
		return new self($in->getLFloat());
	}

	public function write(PacketSerializer $out) : void{
		$out->putLFloat($this->value);
	}
}
