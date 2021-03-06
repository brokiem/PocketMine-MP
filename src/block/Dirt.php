<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\item\Hoe;
use pocketmine\item\Item;
use pocketmine\math\Facing;
use pocketmine\math\Vector3;
use pocketmine\player\Player;

class Dirt extends Opaque{

	protected bool $coarse = false;

	public function readStateFromData(int $id, int $stateMeta) : void{
		$this->coarse = ($stateMeta & BlockLegacyMetadata::DIRT_FLAG_COARSE) !== 0;
	}

	protected function writeStateToMeta() : int{
		return $this->coarse ? BlockLegacyMetadata::DIRT_FLAG_COARSE : 0;
	}

	public function getStateBitmask() : int{
		return 0b1;
	}

	public function getNonPersistentStateBitmask() : int{
		return 0;
	}

	public function isCoarse() : bool{ return $this->coarse; }

	/** @return $this */
	public function setCoarse(bool $coarse) : self{
		$this->coarse = $coarse;
		return $this;
	}

	public function onInteract(Item $item, int $face, Vector3 $clickVector, ?Player $player = null) : bool{
		if($face === Facing::UP and $item instanceof Hoe){
			$item->applyDamage(1);
			$this->pos->getWorld()->setBlock($this->pos, $this->coarse ? VanillaBlocks::DIRT() : VanillaBlocks::FARMLAND());

			return true;
		}

		return false;
	}
}
