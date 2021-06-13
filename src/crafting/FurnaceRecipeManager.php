<?php

declare(strict_types=1);

namespace pocketmine\crafting;

use pocketmine\item\Item;
use pocketmine\utils\ObjectSet;

final class FurnaceRecipeManager{
	/** @var FurnaceRecipe[] */
	protected $furnaceRecipes = [];

	/**
	 * @var ObjectSet
	 * @phpstan-var ObjectSet<\Closure(FurnaceRecipe) : void>
	 */
	private $recipeRegisteredCallbacks;

	public function __construct(){
		$this->recipeRegisteredCallbacks = new ObjectSet();
	}

	/**
	 * @phpstan-return ObjectSet<\Closure(FurnaceRecipe) : void>
	 */
	public function getRecipeRegisteredCallbacks() : ObjectSet{
		return $this->recipeRegisteredCallbacks;
	}

	/**
	 * @return FurnaceRecipe[]
	 */
	public function getAll() : array{
		return $this->furnaceRecipes;
	}

	public function register(FurnaceRecipe $recipe) : void{
		$input = $recipe->getInput();
		$this->furnaceRecipes[$input->getId() . ":" . ($input->hasAnyDamageValue() ? "?" : $input->getMeta())] = $recipe;
		foreach($this->recipeRegisteredCallbacks as $callback){
			$callback($recipe);
		}
	}

	public function match(Item $input) : ?FurnaceRecipe{
		return $this->furnaceRecipes[$input->getId() . ":" . $input->getMeta()] ?? $this->furnaceRecipes[$input->getId() . ":?"] ?? null;
	}
}