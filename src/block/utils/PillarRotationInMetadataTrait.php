<?php

declare(strict_types=1);

namespace pocketmine\block\utils;

use pocketmine\math\Axis;

trait PillarRotationInMetadataTrait{
	use PillarRotationTrait;

	protected function getAxisMetaShift() : int{
		return 2; //default
	}

	/**
	 * @see Block::writeStateToMeta()
	 */
	protected function writeStateToMeta() : int{
		return $this->writeAxisToMeta();
	}

	/**
	 * @see Block::readStateFromData()
	 */
	public function readStateFromData(int $id, int $stateMeta) : void{
		$this->readAxisFromMeta($stateMeta);
	}

	/**
	 * @see Block::getStateBitmask()
	 */
	public function getStateBitmask() : int{
		return 0b11 << $this->getAxisMetaShift();
	}

	protected function readAxisFromMeta(int $meta) : void{
		$axis = $meta >> $this->getAxisMetaShift();
		$mapped = [
			0 => Axis::Y,
			1 => Axis::X,
			2 => Axis::Z
		][$axis] ?? null;
		if($mapped === null){
			throw new InvalidBlockStateException("Invalid axis meta $axis");
		}
		$this->axis = $mapped;
	}

	protected function writeAxisToMeta() : int{
		return [
			Axis::Y => 0,
			Axis::Z => 2,
			Axis::X => 1
		][$this->axis] << $this->getAxisMetaShift();
	}
}
