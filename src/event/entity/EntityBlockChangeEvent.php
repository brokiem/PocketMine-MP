<?php

declare(strict_types=1);

namespace pocketmine\event\entity;

use pocketmine\block\Block;
use pocketmine\entity\Entity;
use pocketmine\event\Cancellable;
use pocketmine\event\CancellableTrait;

/**
 * Called when an Entity, excluding players, changes a block directly
 * @phpstan-extends EntityEvent<Entity>
 */
class EntityBlockChangeEvent extends EntityEvent implements Cancellable{
	use CancellableTrait;

	/** @var Block */
	private $from;
	/** @var Block */
	private $to;

	public function __construct(Entity $entity, Block $from, Block $to){
		$this->entity = $entity;
		$this->from = $from;
		$this->to = $to;
	}

	public function getBlock() : Block{
		return $this->from;
	}

	public function getTo() : Block{
		return $this->to;
	}
}
