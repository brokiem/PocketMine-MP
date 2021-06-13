<?php

declare(strict_types=1);

namespace pocketmine\event\entity;

use pocketmine\entity\Entity;
use pocketmine\event\Cancellable;
use pocketmine\event\CancellableTrait;

/**
 * Called when a entity decides to explode
 * @phpstan-extends EntityEvent<Entity>
 */
class ExplosionPrimeEvent extends EntityEvent implements Cancellable{
	use CancellableTrait;

	/** @var float */
	protected $force;
	/** @var bool */
	private $blockBreaking;

	public function __construct(Entity $entity, float $force){
		$this->entity = $entity;
		$this->force = $force;
		$this->blockBreaking = true;
	}

	public function getForce() : float{
		return $this->force;
	}

	public function setForce(float $force) : void{
		$this->force = $force;
	}

	public function isBlockBreaking() : bool{
		return $this->blockBreaking;
	}

	public function setBlockBreaking(bool $affectsBlocks) : void{
		$this->blockBreaking = $affectsBlocks;
	}
}
