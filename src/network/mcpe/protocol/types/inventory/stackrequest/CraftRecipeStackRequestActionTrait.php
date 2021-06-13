<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types\inventory\stackrequest;

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

trait CraftRecipeStackRequestActionTrait{

	/** @var int */
	private $recipeId;

	final public function __construct(int $recipeId){
		$this->recipeId = $recipeId;
	}

	public function getRecipeId() : int{ return $this->recipeId; }

	public static function read(PacketSerializer $in) : self{
		$recipeId = $in->readGenericTypeNetworkId();
		return new self($recipeId);
	}

	public function write(PacketSerializer $out) : void{
		$out->writeGenericTypeNetworkId($this->recipeId);
	}
}
