<?php

declare(strict_types=1);

namespace pocketmine\event\entity;

use pocketmine\entity\projectile\Projectile;
use pocketmine\math\RayTraceResult;

/**
 * @allowHandle
 * @phpstan-extends EntityEvent<Projectile>
 */
abstract class ProjectileHitEvent extends EntityEvent{
	/** @var RayTraceResult */
	private $rayTraceResult;

	public function __construct(Projectile $entity, RayTraceResult $rayTraceResult){
		$this->entity = $entity;
		$this->rayTraceResult = $rayTraceResult;
	}

	/**
	 * @return Projectile
	 */
	public function getEntity(){
		return $this->entity;
	}

	/**
	 * Returns a RayTraceResult object containing information such as the exact position struck, the AABB it hit, and
	 * the face of the AABB that it hit.
	 */
	public function getRayTraceResult() : RayTraceResult{
		return $this->rayTraceResult;
	}
}
