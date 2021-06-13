<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\block\utils\AnalogRedstoneSignalEmitterTrait;
use pocketmine\block\utils\BlockDataSerializer;

abstract class WeightedPressurePlate extends PressurePlate{
	use AnalogRedstoneSignalEmitterTrait;

	protected function writeStateToMeta() : int{
		return $this->signalStrength;
	}

	public function readStateFromData(int $id, int $stateMeta) : void{
		$this->signalStrength = BlockDataSerializer::readBoundedInt("signalStrength", $stateMeta, 0, 15);
	}

	public function getStateBitmask() : int{
		return 0b1111;
	}
}
