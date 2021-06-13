<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\math\Axis;
use pocketmine\math\AxisAlignedBB;
use pocketmine\math\Facing;
use function count;

class Thin extends Transparent{
	/** @var bool[] facing => dummy */
	protected array $connections = [];

	public function readStateFromWorld() : void{
		parent::readStateFromWorld();

		foreach(Facing::HORIZONTAL as $facing){
			$side = $this->getSide($facing);
			if($side instanceof Thin or $side->isFullCube()){
				$this->connections[$facing] = true;
			}else{
				unset($this->connections[$facing]);
			}
		}
	}

	protected function recalculateCollisionBoxes() : array{
		$inset = 7 / 16;

		/** @var AxisAlignedBB[] $bbs */
		$bbs = [];

		if(isset($this->connections[Facing::WEST]) or isset($this->connections[Facing::EAST])){
			$bb = AxisAlignedBB::one()->squash(Axis::Z, $inset);

			if(!isset($this->connections[Facing::WEST])){
				$bb->trim(Facing::WEST, $inset);
			}elseif(!isset($this->connections[Facing::EAST])){
				$bb->trim(Facing::EAST, $inset);
			}
			$bbs[] = $bb;
		}

		if(isset($this->connections[Facing::NORTH]) or isset($this->connections[Facing::SOUTH])){
			$bb = AxisAlignedBB::one()->squash(Axis::X, $inset);

			if(!isset($this->connections[Facing::NORTH])){
				$bb->trim(Facing::NORTH, $inset);
			}elseif(!isset($this->connections[Facing::SOUTH])){
				$bb->trim(Facing::SOUTH, $inset);
			}
			$bbs[] = $bb;
		}

		if(count($bbs) === 0){
			//centre post AABB (only needed if not connected on any axis - other BBs overlapping will do this if any connections are made)
			return [
				AxisAlignedBB::one()->contract($inset, 0, $inset)
			];
		}

		return $bbs;
	}
}
