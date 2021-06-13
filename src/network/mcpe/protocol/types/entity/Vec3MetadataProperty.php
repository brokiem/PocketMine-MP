<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types\entity;

use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class Vec3MetadataProperty implements MetadataProperty{
	/** @var Vector3 */
	private $value;

	public function __construct(Vector3 $value){
		$this->value = $value->asVector3();
	}

	public function getValue() : Vector3{
		return clone $this->value;
	}

	public static function id() : int{
		return EntityMetadataTypes::VECTOR3F;
	}

	public static function read(PacketSerializer $in) : self{
		return new self($in->getVector3());
	}

	public function write(PacketSerializer $out) : void{
		$out->putVector3($this->value);
	}

	public function equals(MetadataProperty $other) : bool{
		return $other instanceof self and $other->value->equals($this->value);
	}
}
