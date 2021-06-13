<?php

declare(strict_types=1);

namespace pocketmine\event\entity;

use pocketmine\entity\Entity;

class EntityCombustByEntityEvent extends EntityCombustEvent{
	/** @var Entity */
	protected $combuster;

	public function __construct(Entity $combuster, Entity $combustee, int $duration){
		parent::__construct($combustee, $duration);
		$this->combuster = $combuster;
	}

	public function getCombuster() : Entity{
		return $this->combuster;
	}
}
