<?php

declare(strict_types=1);

namespace pocketmine\block;

abstract class SimplePressurePlate extends PressurePlate{

	protected bool $pressed = false;

	protected function writeStateToMeta() : int{
		return $this->pressed ? BlockLegacyMetadata::PRESSURE_PLATE_FLAG_POWERED : 0;
	}

	public function readStateFromData(int $id, int $stateMeta) : void{
		$this->pressed = ($stateMeta & BlockLegacyMetadata::PRESSURE_PLATE_FLAG_POWERED) !== 0;
	}

	public function getStateBitmask() : int{
		return 0b1;
	}

	public function isPressed() : bool{ return $this->pressed; }

	/** @return $this */
	public function setPressed(bool $pressed) : self{
		$this->pressed = $pressed;
		return $this;
	}
}
