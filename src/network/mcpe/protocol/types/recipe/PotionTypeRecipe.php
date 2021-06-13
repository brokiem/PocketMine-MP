<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types\recipe;

class PotionTypeRecipe{
	/** @var int */
	private $inputItemId;
	/** @var int */
	private $inputItemMeta;
	/** @var int */
	private $ingredientItemId;
	/** @var int */
	private $ingredientItemMeta;
	/** @var int */
	private $outputItemId;
	/** @var int */
	private $outputItemMeta;

	public function __construct(int $inputItemId, int $inputItemMeta, int $ingredientItemId, int $ingredientItemMeta, int $outputItemId, int $outputItemMeta){
		$this->inputItemId = $inputItemId;
		$this->inputItemMeta = $inputItemMeta;
		$this->ingredientItemId = $ingredientItemId;
		$this->ingredientItemMeta = $ingredientItemMeta;
		$this->outputItemId = $outputItemId;
		$this->outputItemMeta = $outputItemMeta;
	}

	public function getInputItemId() : int{
		return $this->inputItemId;
	}

	public function getInputItemMeta() : int{
		return $this->inputItemMeta;
	}

	public function getIngredientItemId() : int{
		return $this->ingredientItemId;
	}

	public function getIngredientItemMeta() : int{
		return $this->ingredientItemMeta;
	}

	public function getOutputItemId() : int{
		return $this->outputItemId;
	}

	public function getOutputItemMeta() : int{
		return $this->outputItemMeta;
	}
}
