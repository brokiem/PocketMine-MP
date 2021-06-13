<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types\entity;

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

interface MetadataProperty{

	public static function id() : int;

	public function write(PacketSerializer $out) : void;

	public function equals(MetadataProperty $other) : bool;
}
