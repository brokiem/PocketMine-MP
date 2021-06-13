<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types\entity;

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

final class ShortMetadataProperty implements MetadataProperty{
	use IntegerishMetadataProperty;

	protected function min() : int{
		return -0x8000;
	}

	protected function max() : int{
		return 0x7fff;
	}

	public static function id() : int{
		return EntityMetadataTypes::SHORT;
	}

	public static function read(PacketSerializer $in) : self{
		return new self($in->getSignedLShort());
	}

	public function write(PacketSerializer $out) : void{
		$out->putLShort($this->value);
	}
}
