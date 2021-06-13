<?php

declare(strict_types=1);

namespace pocketmine\event\entity;

use pocketmine\entity\object\ItemEntity;

/**
 * @phpstan-extends EntityEvent<ItemEntity>
 */
class ItemSpawnEvent extends EntityEvent{

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
