<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types\entity;

use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

final class BlockPosMetadataProperty implements MetadataProperty{

	/** @var Vector3 */
	private $value;

	public function __construct(Vector3 $value){
		$this->value = $value->floor();
	}

	public function getValue() : Vector3{
		return $this->value;
	}

	public static function id() : int{
		return EntityMetadataTypes::POS;
	}

	public static function read(PacketSerializer $in) : self{
		$x = $y = $z = 0;
		$in->getSignedBlockPosition($x, $y, $z);
		return new self(new Vector3($x, $y, $z));
	}

	public function write(PacketSerializer $out) : void{
		$out->putSignedBlockPosition($this->value->x, $this->value->y, $this->value->z);
	}

	public function equals(MetadataProperty $other) : bool{
		return $other instanceof self and $other->value->equals($this->value);
	}
}
