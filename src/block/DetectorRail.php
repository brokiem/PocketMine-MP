<?php

declare(strict_types=1);

namespace pocketmine\block;

class DetectorRail extends BaseRail{
	protected bool $activated = false;

	public function isActivated() : bool{ return $this->activated; }

	/** @return $this */
	public function setActivated(bool $activated) : self{
		$this->activated = $activated;
		return $this;
	}

	protected function writeStateToMeta() : int{
		return parent::writeStateToMeta() | ($this->activated ? BlockLegacyMetadata::REDSTONE_RAIL_FLAG_POWERED : 0);
	}

	public function readStateFromData(int $id, int $stateMeta) : void{
		parent::readStateFromData($id, $stateMeta);
		$this->activated = ($stateMeta & BlockLegacyMetadata::REDSTONE_RAIL_FLAG_POWERED) !== 0;
	}

	protected function getConnectionsFromMeta(int $meta) : ?array{
		return self::CONNECTIONS[$meta & ~BlockLegacyMetadata::REDSTONE_RAIL_FLAG_POWERED] ?? null;
	}

	//TODO
}
