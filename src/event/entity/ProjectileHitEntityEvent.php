<?php

declare(strict_types=1);

namespace pocketmine\event\entity;

use pocketmine\entity\Entity;
use pocketmine\entity\projectile\Projectile;
use pocketmine\math\RayTraceResult;

class ProjectileHitEntityEvent extends ProjectileHitEvent{
	/** @var Entity */
	private $entityHit;

	public function __construct(Projectile $entity, RayTraceResult $rayTraceResult, Entity $entityHit){
		parent::__construct($entity, $rayTraceResult);
		$this->entityHit = $entityHit;
	}

	/**
	 * Returns the Entity struck by the projectile.
	 */
	public function getEntityHit() : Entity{
		return $this->entityHit;
	}
}
