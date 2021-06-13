<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\block\utils\AnalogRedstoneSignalEmitterTrait;
use pocketmine\block\utils\BlockDataSerializer;

class RedstoneWire extends Flowable{
	use AnalogRedstoneSignalEmitterTrait;

	public function readStateFromData(int $id, int $stateMeta) : void{
		$this->signalStrength = BlockDataSerializer::readBoundedInt("signalStrength", $stateMeta, 0, 15);
	}

	protected function writeStateToMeta() : int{
		return $this->signalStrength;
	}

	public function getStateBitmask() : int{
		return 0b1111;
	}

	public function readStateFromWorld() : void{
		parent::readStateFromWorld();
		//TODO: check connections to nearby redstone components
	}
}
