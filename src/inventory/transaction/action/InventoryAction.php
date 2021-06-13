<?php

declare(strict_types=1);

namespace pocketmine\inventory\transaction\action;

use pocketmine\inventory\transaction\InventoryTransaction;
use pocketmine\inventory\transaction\TransactionValidationException;
use pocketmine\item\Item;
use pocketmine\player\Player;

/**
 * Represents an action involving a change that applies in some way to an inventory or other item-source.
 */
abstract class InventoryAction{
	/** @var Item */
	protected $sourceItem;
	/** @var Item */
	protected $targetItem;

	public function __construct(Item $sourceItem, Item $targetItem){
		$this->sourceItem = $sourceItem;
		$this->targetItem = $targetItem;
	}

	/**
	 * Returns the item that was present before the action took place.
	 */
	public function getSourceItem() : Item{
		return clone $this->sourceItem;
	}

	/**
	 * Returns the item that the action attempted to replace the source item with.
	 */
	public function getTargetItem() : Item{
		return clone $this->targetItem;
	}

	/**
	 * Returns whether this action is currently valid. This should perform any necessary sanity checks.
	 *
	 * @throws TransactionValidationException
	 */
	abstract public function validate(Player $source) : void;

	/**
	 * Called when the action is added to the specified InventoryTransaction.
	 */
	public function onAddToTransaction(InventoryTransaction $transaction) : void{

	}

	/**
	 * Called by inventory transactions before any actions are processed. If this returns false, the transaction will
	 * be cancelled.
	 */
	public function onPreExecute(Player $source) : bool{
		return true;
	}

	/**
	 * Performs actions needed to complete the inventory-action server-side. This will only be called if the transaction
	 * which it is part of is considered valid.
	 */
	abstract public function execute(Player $source) : void;
}
