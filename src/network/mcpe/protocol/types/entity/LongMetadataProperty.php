<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types\entity;

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;
use const PHP_INT_MAX;
use const PHP_INT_MIN;

final class LongMetadataProperty implements MetadataProperty{
	use IntegerishMetadataProperty;

	protected function min() : int{
		return PHP_INT_MIN;
	}

	protected function max() : int{
		return PHP_INT_MAX;
	}

	public static function id() : int{
		return EntityMetadataTypes::LONG;
	}

	public static function read(PacketSerializer $in) : self{
		return new self($in->getVarLong());
	}

	public function write(PacketSerializer $out) : void{
		$out->putVarLong($this->value);
	}
}
