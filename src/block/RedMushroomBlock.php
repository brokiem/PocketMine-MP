<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\item\Item;
use function mt_rand;

class RedMushroomBlock extends Opaque{

	/**
	 * @var int
	 * In PC they have blockstate properties for each of the sides (pores/not pores). Unfortunately, we can't support
	 * that because we can't serialize 2^6 combinations into a 4-bit metadata value, so this has to stick with storing
	 * the legacy crap for now.
	 * TODO: change this once proper blockstates are implemented
	 */
	protected int $rotationData = 0;

	protected function writeStateToMeta() : int{
		return $this->rotationData;
	}

	public function readStateFromData(int $id, int $stateMeta) : void{
		$this->rotationData = $stateMeta;
	}

	public function getStateBitmask() : int{
		return 0b1111;
	}

	public function getDropsForCompatibleTool(Item $item) : array{
		return [
			VanillaBlocks::RED_MUSHROOM()->asItem()->setCount(mt_rand(0, 2))
		];
	}

	public function isAffectedBySilkTouch() : bool{
		return true;
	}
}
