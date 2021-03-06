<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\block\tile\Hopper as TileHopper;
use pocketmine\block\utils\BlockDataSerializer;
use pocketmine\block\utils\InvalidBlockStateException;
use pocketmine\block\utils\PoweredByRedstoneTrait;
use pocketmine\item\Item;
use pocketmine\math\AxisAlignedBB;
use pocketmine\math\Facing;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\world\BlockTransaction;

class Hopper extends Transparent{
	use PoweredByRedstoneTrait;

	private int $facing = Facing::DOWN;

	public function readStateFromData(int $id, int $stateMeta) : void{
		$facing = BlockDataSerializer::readFacing($stateMeta & 0x07);
		if($facing === Facing::UP){
			throw new InvalidBlockStateException("Hopper may not face upward");
		}
		$this->facing = $facing;
		$this->powered = ($stateMeta & BlockLegacyMetadata::HOPPER_FLAG_POWERED) !== 0;
	}

	protected function writeStateToMeta() : int{
		return BlockDataSerializer::writeFacing($this->facing) | ($this->powered ? BlockLegacyMetadata::HOPPER_FLAG_POWERED : 0);
	}

	public function getStateBitmask() : int{
		return 0b1111;
	}

	public function getFacing() : int{ return $this->facing; }

	/** @return $this */
	public function setFacing(int $facing) : self{
		if($facing === Facing::UP){
			throw new \InvalidArgumentException("Hopper may not face upward");
		}
		$this->facing = $facing;
		return $this;
	}

	protected function recalculateCollisionBoxes() : array{
		$result = [
			AxisAlignedBB::one()->trim(Facing::UP, 6 / 16) //the empty area around the bottom is currently considered solid
		];

		foreach(Facing::HORIZONTAL as $f){ //add the frame parts around the bowl
			$result[] = AxisAlignedBB::one()->trim($f, 14 / 16);
		}
		return $result;
	}

	public function place(BlockTransaction $tx, Item $item, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector, ?Player $player = null) : bool{
		$this->facing = $face === Facing::DOWN ? Facing::DOWN : Facing::opposite($face);

		return parent::place($tx, $item, $blockReplace, $blockClicked, $face, $clickVector, $player);
	}

	public function onInteract(Item $item, int $face, Vector3 $clickVector, ?Player $player = null) : bool{
		if($player !== null){
			$tile = $this->pos->getWorld()->getTile($this->pos);
			if($tile instanceof TileHopper){ //TODO: find a way to have inventories open on click without this boilerplate in every block
				$player->setCurrentWindow($tile->getInventory());
			}
			return true;
		}
		return false;
	}

	public function onScheduledUpdate() : void{
		//TODO
	}

	//TODO: redstone logic, sucking logic
}
