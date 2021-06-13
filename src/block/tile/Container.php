<?php

declare(strict_types=1);

namespace pocketmine\block\tile;

use pocketmine\inventory\Inventory;
use pocketmine\inventory\InventoryHolder;

interface Container extends InventoryHolder{
	public const TAG_ITEMS = "Items";
	public const TAG_LOCK = "Lock";

	/**
	 * @return Inventory
	 */
	public function getRealInventory();

	/**
	 * Returns whether this container can be opened by an item with the given custom name.
	 */
	public function canOpenWith(string $key) : bool;
}
