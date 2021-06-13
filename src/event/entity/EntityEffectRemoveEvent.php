<?php

declare(strict_types=1);

namespace pocketmine\event\entity;

/**
 * Called when an effect is removed from an entity.
 */
class EntityEffectRemoveEvent extends EntityEffectEvent{
	public function cancel() : void{
		if($this->getEffect()->getDuration() <= 0){
			throw new \InvalidStateException("Removal of expired effects cannot be cancelled");
		}
		parent::cancel();
	}
}
