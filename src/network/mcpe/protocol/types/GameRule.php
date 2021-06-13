<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types;

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

abstract class GameRule{

	private bool $playerModifiable;

	public function __construct(bool $isPlayerModifiable){
		$this->playerModifiable = $isPlayerModifiable;
	}

	public function isPlayerModifiable() : bool{ return $this->playerModifiable; }

	abstract public function getType() : int;

	abstract public function encode(PacketSerializer $out) : void;
}
