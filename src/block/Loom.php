<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\block\inventory\LoomInventory;
use pocketmine\block\utils\BlockDataSerializer;
use pocketmine\block\utils\FacesOppositePlacingPlayerTrait;
use pocketmine\block\utils\HorizontalFacingTrait;
use pocketmine\item\Item;
use pocketmine\math\Vector3;
use pocketmine\player\Player;

final class Loom extends Opaque{
	use FacesOppositePlacingPlayerTrait;
	use HorizontalFacingTrait;

	public function readStateFromData(int $id, int $stateMeta) : void{
		$this->facing = BlockDataSerializer::readLegacyHorizontalFacing($stateMeta & 0x3);
	}

	protected function writeStateToMeta() : int{
		return BlockDataSerializer::writeLegacyHorizontalFacing($this->facing);
	}

	public function getStateBitmask() : int{
		return 0b11;
	}

	public function onInteract(Item $item, int $face, Vector3 $clickVector, ?Player $player = null) : bool{
		if($player !== null){
			$player->setCurrentWindow(new LoomInventory($this->pos));
			return true;
		}
		return false;
	}
}
