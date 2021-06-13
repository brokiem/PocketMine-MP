<?php

declare(strict_types=1);

namespace pocketmine\event\entity;

use pocketmine\block\Block;
use pocketmine\entity\Entity;

class EntityCombustByBlockEvent extends EntityCombustEvent{
	/** @var Block */
	protected $combuster;

	public function __construct(Block $combuster, Entity $combustee, int $duration){
		parent::__construct($combustee, $duration);
		$this->combuster = $combuster;
	}

	public function getCombuster() : Block{
		return $this->combuster;
	}
}
