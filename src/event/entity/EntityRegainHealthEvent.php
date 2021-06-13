<?php

declare(strict_types=1);

namespace pocketmine\event\entity;

use pocketmine\entity\Entity;
use pocketmine\event\Cancellable;
use pocketmine\event\CancellableTrait;

/**
 * @phpstan-extends EntityEvent<Entity>
 */
class EntityRegainHealthEvent extends EntityEvent implements Cancellable{
	use CancellableTrait;

	public const CAUSE_REGEN = 0;
	public const CAUSE_EATING = 1;
	public const CAUSE_MAGIC = 2;
	public const CAUSE_CUSTOM = 3;
	public const CAUSE_SATURATION = 4;

	/** @var float */
	private $amount;
	/** @var int */
	private $reason;

	public function __construct(Entity $entity, float $amount, int $regainReason){
		$this->entity = $entity;
		$this->amount = $amount;
		$this->reason = $regainReason;
	}

	public function getAmount() : float{
		return $this->amount;
	}

	public function setAmount(float $amount) : void{
		$this->amount = $amount;
	}

	/**
	 * Returns one of the CAUSE_* constants to indicate why this regeneration occurred.
	 */
	public function getRegainReason() : int{
		return $this->reason;
	}
}
