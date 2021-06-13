<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types\recipe;

class PotionContainerChangeRecipe{
	/** @var int */
	private $inputItemId;
	/** @var int */
	private $ingredientItemId;
	/** @var int */
	private $outputItemId;

	public function __construct(int $inputItemId, int $ingredientItemId, int $outputItemId){
		$this->inputItemId = $inputItemId;
		$this->ingredientItemId = $ingredientItemId;
		$this->outputItemId = $outputItemId;
	}

	public function getInputItemId() : int{
		return $this->inputItemId;
	}

	public function getIngredientItemId() : int{
		return $this->ingredientItemId;
	}

	public function getOutputItemId() : int{
		return $this->outputItemId;
	}
}
