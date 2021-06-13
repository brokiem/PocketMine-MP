<?php

declare(strict_types=1);

namespace pocketmine\event\entity;

use pocketmine\entity\object\ItemEntity;
use pocketmine\event\Cancellable;
use pocketmine\event\CancellableTrait;

/**
 * @phpstan-extends EntityEvent<ItemEntity>
 */
class ItemEntityDropEvent extends EntityEvent implements Cancellable{
	use CancellableTrait;

	public function __construct(ItemEntity $item){
		$this->entity = $item;
	}

	/**
	 * @return ItemEntity
	 */
	public function getEntity(){
		return $this->entity;
	}
}
