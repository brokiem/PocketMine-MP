<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\block\utils\BlockDataSerializer;
use pocketmine\item\Item;
use pocketmine\item\VanillaItems;

class NetherReactor extends Opaque{

	protected int $state = BlockLegacyMetadata::NETHER_REACTOR_INACTIVE;

	protected function writeStateToMeta() : int{
		return $this->state;
	}

	public function readStateFromData(int $id, int $stateMeta) : void{
		$this->state = BlockDataSerializer::readBoundedInt("state", $stateMeta, 0, 2);
	}

	public function getStateBitmask() : int{
		return 0b11;
	}

	public function getDropsForCompatibleTool(Item $item) : array{
		return [
			VanillaItems::IRON_INGOT()->setCount(6),
			VanillaItems::DIAMOND()->setCount(3)
		];
	}
}
