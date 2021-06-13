<?php

declare(strict_types=1);

namespace pocketmine\crafting;

use pocketmine\item\Item;
use pocketmine\utils\AssumptionFailedError;
use function array_map;
use function file_get_contents;
use function is_array;
use function json_decode;

final class CraftingManagerFromDataHelper{

	public static function make(string $filePath) : CraftingManager{
		$recipes = json_decode(file_get_contents($filePath), true);
		if(!is_array($recipes)){
			throw new AssumptionFailedError("recipes.json root should contain a map of recipe types");
		}
		$result = new CraftingManager();

		$itemDeserializerFunc = \Closure::fromCallable([Item::class, 'jsonDeserialize']);

		foreach($recipes["shapeless"] as $recipe){
			if($recipe["block"] !== "crafting_table"){ //TODO: filter others out for now to avoid breaking economics
				continue;
			}
			$result->registerShapelessRecipe(new ShapelessRecipe(
				array_map($itemDeserializerFunc, $recipe["input"]),
				array_map($itemDeserializerFunc, $recipe["output"])
			));
		}
		foreach($recipes["shaped"] as $recipe){
			if($recipe["block"] !== "crafting_table"){ //TODO: filter others out for now to avoid breaking economics
				continue;
			}
			$result->registerShapedRecipe(new ShapedRecipe(
				$recipe["shape"],
				array_map($itemDeserializerFunc, $recipe["input"]),
				array_map($itemDeserializerFunc, $recipe["output"])
			));
		}
		foreach($recipes["smelting"] as $recipe){
			if($recipe["block"] !== "furnace"){ //TODO: filter others out for now to avoid breaking economics
				continue;
			}
			$result->getFurnaceRecipeManager()->register(new FurnaceRecipe(
				Item::jsonDeserialize($recipe["output"]),
				Item::jsonDeserialize($recipe["input"]))
			);
		}

		return $result;
	}
}
