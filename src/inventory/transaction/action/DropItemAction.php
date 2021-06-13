<?php

declare(strict_types=1);

namespace pocketmine\inventory\transaction\action;

use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\inventory\transaction\TransactionValidationException;
use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use pocketmine\player\Player;

/**
 * Represents an action involving dropping an item into the world.
 */
class DropItemAction extends InventoryAction{

	public function __construct(Item $targetItem){
		parent::__construct(ItemFactory::air(), $targetItem);
	}

	public function validate(Player $source) : void{
		if($this->targetItem->isNull()){
			throw new TransactionValidationException("Cannot drop an empty itemstack");
		}
	}

	public function onPreExecute(Player $source) : bool{
		$ev = new PlayerDropItemEvent($source, $this->targetItem);
		$ev->call();
		if($ev->isCancelled()){
			return false;
		}

		return true;
	}

	/**
	 * Drops the target item in front of the player.
	 */
	public function execute(Player $source) : void{
		$source->dropItem($this->targetItem);
	}
}
