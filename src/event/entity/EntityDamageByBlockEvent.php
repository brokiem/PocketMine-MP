<?php

declare(strict_types=1);

namespace pocketmine\event\entity;

use pocketmine\block\Block;
use pocketmine\entity\Entity;

/**
 * Called when an entity takes damage from a block.
 */
class EntityDamageByBlockEvent extends EntityDamageEvent{
	/** @var Block */
	private $damager;

	/**
	 * @param float[] $modifiers
	 */
	public function __construct(Block $damager, Entity $entity, int $cause, float $damage, array $modifiers = []){
		$this->damager = $damager;
		parent::__construct($entity, $cause, $damage, $modifiers);
	}

	public function getDamager() : Block{
		return $this->damager;
	}
}
