<?php

declare(strict_types=1);

namespace pocketmine\event\entity;

use pocketmine\block\Block;
use pocketmine\entity\projectile\Projectile;
use pocketmine\math\RayTraceResult;

class ProjectileHitBlockEvent extends ProjectileHitEvent{
	/** @var Block */
	private $blockHit;

	public function __construct(Projectile $entity, RayTraceResult $rayTraceResult, Block $blockHit){
		parent::__construct($entity, $rayTraceResult);
		$this->blockHit = $blockHit;
	}

	/**
	 * Returns the Block struck by the projectile.
	 * Hint: to get the block face hit, look at the RayTraceResult.
	 */
	public function getBlockHit() : Block{
		return $this->blockHit;
	}
}
