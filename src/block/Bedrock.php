<?php

declare(strict_types=1);

namespace pocketmine\block;

class Bedrock extends Opaque{

	private bool $burnsForever = false;

	public function readStateFromData(int $id, int $stateMeta) : void{
		$this->burnsForever = ($stateMeta & BlockLegacyMetadata::BEDROCK_FLAG_INFINIBURN) !== 0;
	}

	protected function writeStateToMeta() : int{
		return $this->burnsForever ? BlockLegacyMetadata::BEDROCK_FLAG_INFINIBURN : 0;
	}

	public function getStateBitmask() : int{
		return 0b1;
	}

	public function burnsForever() : bool{
		return $this->burnsForever;
	}

	/** @return $this */
	public function setBurnsForever(bool $burnsForever) : self{
		$this->burnsForever = $burnsForever;
		return $this;
	}
}
