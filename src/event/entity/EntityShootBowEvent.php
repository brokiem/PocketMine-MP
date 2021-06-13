<?php

declare(strict_types=1);

namespace pocketmine\event\entity;

use pocketmine\entity\Entity;
use pocketmine\entity\Living;
use pocketmine\entity\projectile\Projectile;
use pocketmine\event\Cancellable;
use pocketmine\event\CancellableTrait;
use pocketmine\item\Item;
use function count;

/**
 * @phpstan-extends EntityEvent<Living>
 */
class EntityShootBowEvent extends EntityEvent implements Cancellable{
	use CancellableTrait;

	/** @var Item */
	private $bow;
	/** @var Projectile */
	private $projectile;
	/** @var float */
	private $force;

	public function __construct(Living $shooter, Item $bow, Projectile $projectile, float $force){
		$this->entity = $shooter;
		$this->bow = $bow;
		$this->projectile = $projectile;
		$this->force = $force;
	}

	/**
	 * @return Living
	 */
	public function getEntity(){
		return $this->entity;
	}

	public function getBow() : Item{
		return $this->bow;
	}

	/**
	 * Returns the entity considered as the projectile in this event.
	 *
	 * NOTE: This might not return a Projectile if a plugin modified the target entity.
	 */
	public function getProjectile() : Entity{
		return $this->projectile;
	}

	public function setProjectile(Entity $projectile) : void{
		if($projectile !== $this->projectile){
			if(count($this->projectile->getViewers()) === 0){
				$this->projectile->close();
			}
			$this->projectile = $projectile;
		}
	}

	public function getForce() : float{
		return $this->force;
	}

	public function setForce(float $force) : void{
		$this->force = $force;
	}
}
