<?php

declare(strict_types=1);

namespace pocketmine\item;

use pocketmine\entity\Consumable;

/**
 * Interface implemented by objects that can be consumed by mobs.
 */
interface ConsumableItem extends Consumable, Releasable{

	/**
	 * Returns the leftover that this Consumable produces when it is consumed. For Items, this is usually air, but could
	 * be an Item to add to a Player's inventory afterwards (such as a bowl).
	 */
	public function getResidue() : Item;
}
