<?php

declare(strict_types=1);

namespace pocketmine\block\tile;

use pocketmine\inventory\Inventory;
use pocketmine\item\Item;
use pocketmine\nbt\NBT;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\nbt\tag\StringTag;
use pocketmine\world\Position;

/**
 * This trait implements most methods in the {@link Container} interface. It should only be used by Tiles.
 */
trait ContainerTrait{
	/** @var string|null */
	private $lock = null;

	/**
	 * @return Inventory
	 */
	abstract public function getRealInventory();

	protected function loadItems(CompoundTag $tag) : void{
		if(($inventoryTag = $tag->getTag(Container::TAG_ITEMS)) instanceof ListTag){
			$inventory = $this->getRealInventory();
			$listeners = $inventory->getListeners()->toArray();
			$inventory->getListeners()->remove(...$listeners); //prevent any events being fired by initialization
			$inventory->clearAll();
			/** @var CompoundTag $itemNBT */
			foreach($inventoryTag as $itemNBT){
				$inventory->setItem($itemNBT->getByte("Slot"), Item::nbtDeserialize($itemNBT));
			}
			$inventory->getListeners()->add(...$listeners);
		}

		if(($lockTag = $tag->getTag(Container::TAG_LOCK)) instanceof StringTag){
			$this->lock = $lockTag->getValue();
		}
	}

	protected function saveItems(CompoundTag $tag) : void{
		$items = [];
		foreach($this->getRealInventory()->getContents() as $slot => $item){
			$items[] = $item->nbtSerialize($slot);
		}

		$tag->setTag(Container::TAG_ITEMS, new ListTag($items, NBT::TAG_Compound));

		if($this->lock !== null){
			$tag->setString(Container::TAG_LOCK, $this->lock);
		}
	}

	/**
	 * @see Container::canOpenWith()
	 */
	public function canOpenWith(string $key) : bool{
		return $this->lock === null or $this->lock === $key;
	}

	/**
	 * @see Position::asPosition()
	 */
	abstract protected function getPos() : Position;

	/**
	 * @see Tile::onBlockDestroyedHook()
	 */
	protected function onBlockDestroyedHook() : void{
		$inv = $this->getRealInventory();
		$pos = $this->getPos();

		foreach($inv->getContents() as $k => $item){
			$pos->getWorld()->dropItem($pos->add(0.5, 0.5, 0.5), $item);
		}
		$inv->clearAll();
	}
}
