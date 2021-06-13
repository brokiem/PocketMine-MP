<?php

declare(strict_types=1);

namespace pocketmine\event\entity;

use pocketmine\entity\Entity;
use pocketmine\event\Cancellable;
use pocketmine\event\CancellableTrait;
use pocketmine\world\Position;

/**
 * @phpstan-extends EntityEvent<Entity>
 */
class EntityTeleportEvent extends EntityEvent implements Cancellable{
	use CancellableTrait;

	/** @var Position */
	private $from;
	/** @var Position */
	private $to;

	public function __construct(Entity $entity, Position $from, Position $to){
		$this->entity = $entity;
		$this->from = $from;
		$this->to = $to;
	}

	public function getFrom() : Position{
		return $this->from;
	}

	public function getTo() : Position{
		return $this->to;
	}

	public function setTo(Position $to) : void{
		$this->to = $to;
	}
}
