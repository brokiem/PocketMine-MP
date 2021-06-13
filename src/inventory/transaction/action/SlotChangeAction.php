<?php

declare(strict_types=1);

namespace pocketmine\inventory\transaction\action;

use pocketmine\inventory\Inventory;
use pocketmine\inventory\transaction\InventoryTransaction;
use pocketmine\inventory\transaction\TransactionValidationException;
use pocketmine\item\Item;
use pocketmine\player\Player;

/**
 * Represents an action causing a change in an inventory slot.
 */
class SlotChangeAction extends InventoryAction{

	/** @var Inventory */
	protected $inventory;
	/** @var int */
	private $inventorySlot;

	public function __construct(Inventory $inventory, int $inventorySlot, Item $sourceItem, Item $targetItem){
		parent::__construct($sourceItem, $targetItem);
		$this->inventory = $inventory;
		$this->inventorySlot = $inventorySlot;
	}

	/**
	 * Returns the inventory involved in this action.
	 */
	public function getInventory() : Inventory{
		return $this->inventory;
	}

	/**
	 * Returns the slot in the inventory which this action modified.
	 */
	public function getSlot() : int{
		return $this->inventorySlot;
	}

	/**
	 * Checks if the item in the inventory at the specified slot is the same as this action's source item.
	 *
	 * @throws TransactionValidationException
	 */
	public function validate(Player $source) : void{
		if(!$this->inventory->slotExists($this->inventorySlot)){
			throw new TransactionValidationException("Slot does not exist");
		}
		if(!$this->inventory->getItem($this->inventorySlot)->equalsExact($this->sourceItem)){
			throw new TransactionValidationException("Slot does not contain expected original item");
		}
	}

	/**
	 * Adds this action's target inventory to the transaction's inventory list.
	 */
	public function onAddToTransaction(InventoryTransaction $transaction) : void{
		$transaction->addInventory($this->inventory);
	}

	/**
	 * Sets the item into the target inventory.
	 */
	public function execute(Player $source) : void{
		$this->inventory->setItem($this->inventorySlot, $this->targetItem);
	}
}
