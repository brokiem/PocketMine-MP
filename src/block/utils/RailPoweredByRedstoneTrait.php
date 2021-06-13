<?php

declare(strict_types=1);

namespace pocketmine\block\utils;

use pocketmine\block\BlockLegacyMetadata;

trait RailPoweredByRedstoneTrait{
	use PoweredByRedstoneTrait;

	protected function writeStateToMeta() : int{
		return parent::writeStateToMeta() | ($this->powered ? BlockLegacyMetadata::REDSTONE_RAIL_FLAG_POWERED : 0);
	}

	public function readStateFromData(int $id, int $stateMeta) : void{
		parent::readStateFromData($id, $stateMeta);
		$this->powered = ($stateMeta & BlockLegacyMetadata::REDSTONE_RAIL_FLAG_POWERED) !== 0;
	}

	protected function getConnectionsFromMeta(int $meta) : ?array{
		return self::CONNECTIONS[$meta & ~BlockLegacyMetadata::REDSTONE_RAIL_FLAG_POWERED] ?? null;
	}
}
