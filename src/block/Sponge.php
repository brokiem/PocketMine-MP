<?php

declare(strict_types=1);

namespace pocketmine\block;

class Sponge extends Opaque{

	protected bool $wet = false;

	protected function writeStateToMeta() : int{
		return $this->wet ? BlockLegacyMetadata::SPONGE_FLAG_WET : 0;
	}

	public function readStateFromData(int $id, int $stateMeta) : void{
		$this->wet = ($stateMeta & BlockLegacyMetadata::SPONGE_FLAG_WET) !== 0;
	}

	public function getStateBitmask() : int{
		return 0b1;
	}

	public function getNonPersistentStateBitmask() : int{
		return 0;
	}

	public function isWet() : bool{ return $this->wet; }

	/** @return $this */
	public function setWet(bool $wet) : self{
		$this->wet = $wet;
		return $this;
	}
}
