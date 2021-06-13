<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\cache;

use pocketmine\crafting\CraftingManager;
use pocketmine\item\Item;
use pocketmine\network\mcpe\convert\GlobalItemTypeDictionary;
use pocketmine\network\mcpe\convert\TypeConverter;
use pocketmine\network\mcpe\protocol\CraftingDataPacket;
use pocketmine\network\mcpe\protocol\types\inventory\ItemStack;
use pocketmine\network\mcpe\protocol\types\recipe\FurnaceRecipe as ProtocolFurnaceRecipe;
use pocketmine\network\mcpe\protocol\types\recipe\RecipeIngredient;
use pocketmine\network\mcpe\protocol\types\recipe\ShapedRecipe as ProtocolShapedRecipe;
use pocketmine\network\mcpe\protocol\types\recipe\ShapelessRecipe as ProtocolShapelessRecipe;
use pocketmine\timings\Timings;
use pocketmine\utils\Binary;
use pocketmine\utils\SingletonTrait;
use Ramsey\Uuid\Uuid;
use function array_map;
use function spl_object_id;

final class CraftingDataCache{
	use SingletonTrait;

	/**
	 * @var CraftingDataPacket[]
	 * @phpstan-var array<int, CraftingDataPacket>
	 */
	private $caches = [];

	public function getCache(int $dictionaryProtocol, CraftingManager $manager) : CraftingDataPacket{
		$id = spl_object_id($manager);
		if(!isset($this->caches[$id])){
			$manager->getDestructorCallbacks()->add(function() use ($id) : void{
				unset($this->caches[$id]);
			});
			$manager->getRecipeRegisteredCallbacks()->add(function() use ($id) : void{
				unset($this->caches[$id]);
			});
			$this->caches[$id] = $this->buildCraftingDataCache($manager);
		}
		return $this->caches[$id][$dictionaryProtocol];
	}

	/**
	 * Rebuilds the cached CraftingDataPacket.
	 */
	private function buildCraftingDataCache(CraftingManager $manager) : array{
		Timings::$craftingDataCacheRebuild->startTiming();

		$packets = [];

		foreach(GlobalItemTypeDictionary::getInstance()->getDictionaries() as $dictionaryProtocol => $unused){
			$pk = new CraftingDataPacket();
			$pk->cleanRecipes = true;

			$counter = 0;
			$nullUUID = Uuid::fromString(Uuid::NIL);
			$converter = TypeConverter::getInstance();
			foreach($manager->getShapelessRecipes() as $list){
				foreach($list as $recipe){
					$pk->entries[] = new ProtocolShapelessRecipe(
						CraftingDataPacket::ENTRY_SHAPELESS,
						Binary::writeInt(++$counter),
						array_map(function(Item $item) use ($dictionaryProtocol, $converter) : RecipeIngredient{
							return $converter->coreItemStackToRecipeIngredient($dictionaryProtocol, $item);
						}, $recipe->getIngredientList()),
						array_map(function(Item $item) use ($dictionaryProtocol, $converter) : ItemStack{
							return $converter->coreItemStackToNet($dictionaryProtocol, $item);
						}, $recipe->getResults()),
						$nullUUID,
						"crafting_table",
						50,
						$counter
					);
				}
			}
			foreach($manager->getShapedRecipes() as $list){
				foreach($list as $recipe){
					$inputs = [];

					for($row = 0, $height = $recipe->getHeight(); $row < $height; ++$row){
						for($column = 0, $width = $recipe->getWidth(); $column < $width; ++$column){
							$inputs[$row][$column] = $converter->coreItemStackToRecipeIngredient($dictionaryProtocol, $recipe->getIngredient($column, $row));
						}
					}
					$pk->entries[] = $r = new ProtocolShapedRecipe(
						CraftingDataPacket::ENTRY_SHAPED,
						Binary::writeInt(++$counter),
						$inputs,
						array_map(function(Item $item) use ($dictionaryProtocol, $converter) : ItemStack{
							return $converter->coreItemStackToNet($dictionaryProtocol, $item);
						}, $recipe->getResults()),
						$nullUUID,
						"crafting_table",
						50,
						$counter
					);
				}
			}

			foreach($manager->getFurnaceRecipeManager()->getAll() as $recipe){
				$input = $converter->coreItemStackToNet($dictionaryProtocol, $recipe->getInput());
				$pk->entries[] = new ProtocolFurnaceRecipe(
					CraftingDataPacket::ENTRY_FURNACE_DATA,
					$input->getId(),
					$input->getMeta(),
					$converter->coreItemStackToNet($dictionaryProtocol, $recipe->getResult()),
					"furnace"
				);
			}

			$packets[$dictionaryProtocol] = $pk;
		}

		Timings::$craftingDataCacheRebuild->stopTiming();
		return $packets;
	}
}
