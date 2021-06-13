<?php

declare(strict_types=1);

namespace pocketmine\event\entity;

use pocketmine\entity\effect\EffectInstance;
use pocketmine\entity\Entity;

/**
 * Called when an effect is added to an Entity.
 */
class EntityEffectAddEvent extends EntityEffectEvent{
	/** @var EffectInstance|null */
	private $oldEffect;

	public function __construct(Entity $entity, EffectInstance $effect, ?EffectInstance $oldEffect = null){
		parent::__construct($entity, $effect);
		$this->oldEffect = $oldEffect;
	}

	/**
	 * Returns whether the effect addition will replace an existing effect already applied to the entity.
	 */
	public function willModify() : bool{
		return $this->hasOldEffect();
	}

	public function hasOldEffect() : bool{
		return $this->oldEffect instanceof EffectInstance;
	}

	public function getOldEffect() : ?EffectInstance{
		return $this->oldEffect;
	}
}
