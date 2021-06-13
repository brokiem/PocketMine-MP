<?php

declare(strict_types=1);

namespace pocketmine\inventory;

interface InventoryHolder{

	/**
	 * Get the object related inventory
	 *
	 * @return Inventory
	 */
	public function getInventory();
}
