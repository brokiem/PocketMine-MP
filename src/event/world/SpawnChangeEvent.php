<?php

declare(strict_types=1);

namespace pocketmine\event\world;

use pocketmine\world\Position;
use pocketmine\world\World;

/**
 * An event that is called when a world spawn changes.
 * The previous spawn is included
 */
class SpawnChangeEvent extends WorldEvent{
	/** @var Position */
	private $previousSpawn;

	public function __construct(World $world, Position $previousSpawn){
		parent::__construct($world);
		$this->previousSpawn = $previousSpawn;
	}

	public function getPreviousSpawn() : Position{
		return $this->previousSpawn;
	}
}
