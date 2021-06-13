<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\block\utils\AnyFacingTrait;
use pocketmine\block\utils\BlockDataSerializer;
use pocketmine\item\Item;
use pocketmine\math\Axis;
use pocketmine\math\AxisAlignedBB;
use pocketmine\math\Facing;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\world\BlockTransaction;

class EndRod extends Flowable{
	use AnyFacingTrait;

	protected function writeStateToMeta() : int{
		$result = BlockDataSerializer::writeFacing($this->facing);
		if(Facing::axis($this->facing) !== Axis::Y){
			$result ^= 1; //TODO: in PC this is always the same as facing, just PE is stupid
		}

		return $result;
	}

	public function readStateFromData(int $id, int $stateMeta) : void{
		if($stateMeta !== 0 and $stateMeta !== 1){
			$stateMeta ^= 1;
		}

		$this->facing = BlockDataSerializer::readFacing($stateMeta);
	}

	public function getStateBitmask() : int{
		return 0b111;
	}

	public function place(BlockTransaction $tx, Item $item, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector, ?Player $player = null) : bool{
		$this->facing = $face;
		if($blockClicked instanceof EndRod and $blockClicked->facing === $this->facing){
			$this->facing = Facing::opposite($face);
		}

		return parent::place($tx, $item, $blockReplace, $blockClicked, $face, $clickVector, $player);
	}

	public function isSolid() : bool{
		return true;
	}

	public function getLightLevel() : int{
		return 14;
	}

	/**
	 * @return AxisAlignedBB[]
	 */
	protected function recalculateCollisionBoxes() : array{
		$myAxis = Facing::axis($this->facing);

		$bb = AxisAlignedBB::one();
		foreach([Axis::Y, Axis::Z, Axis::X] as $axis){
			if($axis === $myAxis){
				continue;
			}
			$bb->squash($axis, 6 / 16);
		}
		return [$bb];
	}
}
