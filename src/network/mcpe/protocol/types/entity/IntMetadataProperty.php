<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types\entity;

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

final class IntMetadataProperty implements MetadataProperty{
	use IntegerishMetadataProperty;

	protected function min() : int{
		return -0x80000000;
	}

	protected function max() : int{
		return 0x7fffffff;
	}

	public static function id() : int{
		return EntityMetadataTypes::INT;
	}

	public static function read(PacketSerializer $in) : self{
		return new self($in->getVarInt());
	}

	public function write(PacketSerializer $out) : void{
		$out->putVarInt($this->value);
	}
}
