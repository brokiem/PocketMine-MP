<?php

declare(strict_types=1);

namespace pocketmine\event\player;

use pocketmine\entity\Human;
use pocketmine\event\Cancellable;
use pocketmine\event\CancellableTrait;
use pocketmine\event\entity\EntityEvent;

/**
 * Called when a player gains or loses XP levels and/or progress.
 * @phpstan-extends EntityEvent<Human>
 */
class PlayerExperienceChangeEvent extends EntityEvent implements Cancellable{
	use CancellableTrait;

	/** @var Human */
	protected $entity;
	/** @var int */
	private $oldLevel;
	/** @var float */
	private $oldProgress;
	/** @var int|null */
	private $newLevel;
	/** @var float|null */
	private $newProgress;

	public function __construct(Human $player, int $oldLevel, float $oldProgress, ?int $newLevel, ?float $newProgress){
		$this->entity = $player;

		$this->oldLevel = $oldLevel;
		$this->oldProgress = $oldProgress;
		$this->newLevel = $newLevel;
		$this->newProgress = $newProgress;
	}

	public function getOldLevel() : int{
		return $this->oldLevel;
	}

	public function getOldProgress() : float{
		return $this->oldProgress;
	}

	/**
	 * @return int|null null indicates no change
	 */
	public function getNewLevel() : ?int{
		return $this->newLevel;
	}

	/**
	 * @return float|null null indicates no change
	 */
	public function getNewProgress() : ?float{
		return $this->newProgress;
	}

	public function setNewLevel(?int $newLevel) : void{
		$this->newLevel = $newLevel;
	}

	public function setNewProgress(?float $newProgress) : void{
		$this->newProgress = $newProgress;
	}
}
