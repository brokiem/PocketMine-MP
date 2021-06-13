<?php

declare(strict_types=1);

namespace pocketmine\event\entity;

use pocketmine\entity\Entity;
use pocketmine\event\Cancellable;
use pocketmine\event\CancellableTrait;
use pocketmine\math\Vector3;

/**
 * @phpstan-extends EntityEvent<Entity>
 */
class EntityMotionEvent extends EntityEvent implements Cancellable{
	use CancellableTrait;

	/** @var Vector3 */
	private $mot;

	public function __construct(Entity $entity, Vector3 $mot){
		$this->entity = $entity;
		$this->mot = $mot;
	}

	public function getVector() : Vector3{
		return $this->mot;
	}
}
