<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\block\utils\BlockDataSerializer;
use pocketmine\block\utils\FacesOppositePlacingPlayerTrait;
use pocketmine\block\utils\HorizontalFacingTrait;
use pocketmine\item\Item;
use pocketmine\math\Facing;
use pocketmine\math\Vector3;
use pocketmine\player\Player;

final class ChemistryTable extends Opaque{
	use FacesOppositePlacingPlayerTrait;
	use HorizontalFacingTrait;

	public function readStateFromData(int $id, int $stateMeta) : void{
		$this->facing = Facing::opposite(BlockDataSerializer::readLegacyHorizontalFacing($stateMeta & 0x3));
	}

	protected function writeStateToMeta() : int{
		return BlockDataSerializer::writeLegacyHorizontalFacing(Facing::opposite($this->facing));
	}

	public function getStateBitmask() : int{
		return 0b0011;
	}

	public function onInteract(Item $item, int $face, Vector3 $clickVector, ?Player $player = null) : bool{
		//TODO
		return false;
	}
}
