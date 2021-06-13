<?php

declare(strict_types=1);

namespace pocketmine\event\inventory;

use pocketmine\event\Cancellable;
use pocketmine\event\CancellableTrait;
use pocketmine\event\Event;
use pocketmine\inventory\transaction\InventoryTransaction;

/**
 * Called when there is a transaction between two Inventory objects.
 * The source of this can be a Player, entities, mobs, or even hoppers in the future!
 */
class InventoryTransactionEvent extends Event implements Cancellable{
	use CancellableTrait;

	/** @var InventoryTransaction */
	private $transaction;

	public function __construct(InventoryTransaction $transaction){
		$this->transaction = $transaction;
	}

	public function getTransaction() : InventoryTransaction{
		return $this->transaction;
	}
}
