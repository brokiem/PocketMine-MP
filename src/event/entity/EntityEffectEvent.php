<?php

declare(strict_types=1);

namespace pocketmine\event\entity;

use pocketmine\entity\effect\EffectInstance;
use pocketmine\entity\Entity;
use pocketmine\event\Cancellable;
use pocketmine\event\CancellableTrait;

/**
 * @phpstan-extends EntityEvent<Entity>
 */
class EntityEffectEvent extends EntityEvent implements Cancellable{
	use CancellableTrait;

	/** @var EffectInstance */
	private $effect;

	public function __construct(Entity $entity, EffectInstance $effect){
		$this->entity = $entity;
		$this->effect = $effect;
	}

	public function getEffect() : EffectInstance{
		return $this->effect;
	}
}
