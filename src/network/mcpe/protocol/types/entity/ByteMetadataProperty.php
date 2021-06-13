<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types\entity;

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

final class ByteMetadataProperty implements MetadataProperty{
	use IntegerishMetadataProperty;

	protected function min() : int{
		return -0x80;
	}

	protected function max() : int{
		return 0x7f;
	}

	public static function id() : int{
		return EntityMetadataTypes::BYTE;
	}

	public static function read(PacketSerializer $in) : self{
		return new self($in->getByte());
	}

	public function write(PacketSerializer $out) : void{
		$out->putByte($this->value);
	}
}
