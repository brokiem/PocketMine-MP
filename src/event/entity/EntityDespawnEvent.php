<?php

declare(strict_types=1);

namespace pocketmine\event\entity;

use pocketmine\entity\Entity;

/**
 * Called when a entity is despawned
 * @phpstan-extends EntityEvent<Entity>
 */
class EntityDespawnEvent extends EntityEvent{

	public function __construct(Entity $entity){
		$this->entity = $entity;
	}
}
