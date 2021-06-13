<?php

declare(strict_types=1);

/**
 * Entity related Events, like spawn, inventory, attack...
 */
namespace pocketmine\event\entity;

use pocketmine\entity\Entity;
use pocketmine\event\Event;

/**
 * @phpstan-template TEntity of Entity
 */
abstract class EntityEvent extends Event{
	/**
	 * @var Entity
	 * @phpstan-var TEntity
	 */
	protected $entity;

	/**
	 * @return Entity
	 * @phpstan-return TEntity
	 */
	public function getEntity(){
		return $this->entity;
	}
}
