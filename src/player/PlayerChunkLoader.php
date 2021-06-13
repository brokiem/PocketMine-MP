<?php

declare(strict_types=1);

namespace pocketmine\player;

use pocketmine\math\Vector3;
use pocketmine\world\TickingChunkLoader;

final class PlayerChunkLoader implements TickingChunkLoader{

	/** @var Vector3 */
	private $currentLocation;

	public function __construct(Vector3 $currentLocation){
		$this->currentLocation = $currentLocation;
	}

	public function setCurrentLocation(Vector3 $currentLocation) : void{
		$this->currentLocation = $currentLocation;
	}

	public function getX() : float{
		return $this->currentLocation->getFloorX();
	}

	public function getZ() : float{
		return $this->currentLocation->getFloorZ();
	}
}
