<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types\inventory\stackrequest;

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

abstract class ItemStackRequestAction{

	abstract public static function getTypeId() : int;

	abstract public function write(PacketSerializer $out) : void;
}
