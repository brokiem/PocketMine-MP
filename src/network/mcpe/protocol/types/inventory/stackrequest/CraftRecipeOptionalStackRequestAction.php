<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types\inventory\stackrequest;

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

/**
 * Renames an item in an anvil, or map on a cartography table.
 */
final class CraftRecipeOptionalStackRequestAction extends ItemStackRequestAction{

	/** @var int */
	private $recipeId;
	/** @var int */
	private $filterStringIndex;

	public function __construct(int $type, int $filterStringIndex){
		$this->recipeId = $type;
		$this->filterStringIndex = $filterStringIndex;
	}

	public function getRecipeId() : int{ return $this->recipeId; }

	public function getFilterStringIndex() : int{ return $this->filterStringIndex; }

	public static function getTypeId() : int{ return ItemStackRequestActionType::CRAFTING_RECIPE_OPTIONAL; }

	public static function read(PacketSerializer $in) : self{
		$recipeId = $in->readGenericTypeNetworkId();
		$filterStringIndex = $in->getLInt();
		return new self($recipeId, $filterStringIndex);
	}

	public function write(PacketSerializer $out) : void{
		$out->writeGenericTypeNetworkId($this->recipeId);
		$out->putLInt($this->filterStringIndex);
	}
}
