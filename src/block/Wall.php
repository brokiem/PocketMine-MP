<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\math\AxisAlignedBB;
use pocketmine\math\Facing;

class Wall extends Transparent{

	/** @var int[] facing => facing */
	protected array $connections = [];
	protected bool $up = false;

	public function readStateFromWorld() : void{
		parent::readStateFromWorld();

		foreach(Facing::HORIZONTAL as $facing){
			$block = $this->getSide($facing);
			if($block instanceof static or $block instanceof FenceGate or ($block->isSolid() and !$block->isTransparent())){
				$this->connections[$facing] = $facing;
			}else{
				unset($this->connections[$facing]);
			}
		}

		$this->up = $this->getSide(Facing::UP)->getId() !== BlockLegacyIds::AIR;
	}

	protected function recalculateCollisionBoxes() : array{
		//walls don't have any special collision boxes like fences do

		$north = isset($this->connections[Facing::NORTH]);
		$south = isset($this->connections[Facing::SOUTH]);
		$west = isset($this->connections[Facing::WEST]);
		$east = isset($this->connections[Facing::EAST]);

		$inset = 0.25;
		if(
			!$this->up and //if there is a block on top, it stays as a post
			(
				($north and $south and !$west and !$east) or
				(!$north and !$south and $west and $east)
			)
		){
			//If connected to two sides on the same axis but not any others, AND there is not a block on top, there is no post and the wall is thinner
			$inset = 0.3125;
		}

		return [
			AxisAlignedBB::one()
				->extend(Facing::UP, 0.5)
				->trim(Facing::NORTH, $north ? 0 : $inset)
				->trim(Facing::SOUTH, $south ? 0 : $inset)
				->trim(Facing::WEST, $west ? 0 : $inset)
				->trim(Facing::EAST, $east ? 0 : $inset)
		];
	}
}
