<?php

declare(strict_types=1);

namespace pocketmine\inventory;

use pocketmine\item\Item;

/**
 * Classes implementing this interface can be injected into inventories to receive notifications when content changes
 * occur.
 * @see CallbackInventoryListener for a closure-based listener
 * @see Inventory::getListeners()
 */
interface InventoryListener{

	public function onSlotChange(Inventory $inventory, int $slot, Item $oldItem) : void;

	/**
	 * @param Item[] $oldContents
	 */
	public function onContentChange(Inventory $inventory, array $oldContents) : void;
}
