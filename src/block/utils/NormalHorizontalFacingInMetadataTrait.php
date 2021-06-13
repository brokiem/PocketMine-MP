<?php

declare(strict_types=1);

namespace pocketmine\block\utils;

trait NormalHorizontalFacingInMetadataTrait{
	use HorizontalFacingTrait;

	protected function writeStateToMeta() : int{
		return BlockDataSerializer::writeHorizontalFacing($this->facing);
	}

	public function readStateFromData(int $id, int $stateMeta) : void{
		$this->facing = BlockDataSerializer::readHorizontalFacing($stateMeta);
	}

	public function getStateBitmask() : int{
		return 0b111;
	}
}
