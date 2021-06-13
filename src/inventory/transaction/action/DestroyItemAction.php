<?php

declare(strict_types=1);

namespace pocketmine\inventory\transaction\action;

use pocketmine\inventory\transaction\TransactionValidationException;
use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use pocketmine\player\Player;

/**
 * This action type shows up when a creative player puts an item into the creative inventory menu to destroy it.
 * The output is the item destroyed. You can think of this action type like setting an item into /dev/null
 */
class DestroyItemAction extends InventoryAction{

	public function __construct(Item $targetItem){
		parent::__construct(ItemFactory::air(), $targetItem);
	}

	public function validate(Player $source) : void{
		if($source->hasFiniteResources()){
			throw new TransactionValidationException("Player has finite resources, cannot destroy items");
		}
	}

	public function execute(Player $source) : void{
		//NOOP
	}
}
