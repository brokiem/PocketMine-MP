<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types\entity;

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

final class StringMetadataProperty implements MetadataProperty{
	/** @var string */
	private $value;

	public function __construct(string $value){
		$this->value = $value;
	}

	public static function id() : int{
		return EntityMetadataTypes::STRING;
	}

	public static function read(PacketSerializer $in) : self{
		return new self($in->getString());
	}

	public function write(PacketSerializer $out) : void{
		$out->putString($this->value);
	}

	public function equals(MetadataProperty $other) : bool{
		return $other instanceof self and $other->value === $this->value;
	}
}
