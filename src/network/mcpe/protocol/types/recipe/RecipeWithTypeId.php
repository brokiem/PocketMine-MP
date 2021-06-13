<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types\recipe;

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

abstract class RecipeWithTypeId{
	/** @var int */
	private $typeId;

	protected function __construct(int $typeId){
		$this->typeId = $typeId;
	}

	final public function getTypeId() : int{
		return $this->typeId;
	}

	abstract public function encode(PacketSerializer $out) : void;
}
