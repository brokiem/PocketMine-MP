<?php

declare(strict_types=1);

namespace pocketmine\event\inventory;

use pocketmine\entity\object\ItemEntity;
use pocketmine\event\Cancellable;
use pocketmine\event\CancellableTrait;
use pocketmine\inventory\Inventory;

class InventoryPickupItemEvent extends InventoryEvent implements Cancellable{
	use CancellableTrait;

	/** @var ItemEntity */
	private $itemEntity;

	public function __construct(Inventory $inventory, ItemEntity $itemEntity){
		$this->itemEntity = $itemEntity;
		parent::__construct($inventory);
	}

	public function getItemEntity() : ItemEntity{
		return $this->itemEntity;
	}
}
