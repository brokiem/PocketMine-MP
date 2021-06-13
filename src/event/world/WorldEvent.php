<?php

declare(strict_types=1);

/**
 * World related events
 */
namespace pocketmine\event\world;

use pocketmine\event\Event;
use pocketmine\world\World;

abstract class WorldEvent extends Event{
	/** @var World */
	private $world;

	public function __construct(World $world){
		$this->world = $world;
	}

	public function getWorld() : World{
		return $this->world;
	}
}
