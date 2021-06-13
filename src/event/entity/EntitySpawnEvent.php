<?php

declare(strict_types=1);

namespace pocketmine\event\entity;

use pocketmine\entity\Entity;

/**
 * Called when a entity is spawned
 * @phpstan-extends EntityEvent<Entity>
 */
class EntitySpawnEvent extends EntityEvent{

	public function __construct(Entity $entity){
		$this->entity = $entity;
	}
}
