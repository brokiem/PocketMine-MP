<?php

declare(strict_types=1);

namespace pocketmine\block\tile;

use pocketmine\block\RedstoneComparator;
use pocketmine\nbt\tag\CompoundTag;

/**
 * @deprecated
 * @see RedstoneComparator
 */
class Comparator extends Tile{
	private const TAG_OUTPUT_SIGNAL = "OutputSignal"; //int

	/** @var int */
	protected $signalStrength = 0;

	public function getSignalStrength() : int{
		return $this->signalStrength;
	}

	public function setSignalStrength(int $signalStrength) : void{
		$this->signalStrength = $signalStrength;
	}

	public function readSaveData(CompoundTag $nbt) : void{
		$this->signalStrength = $nbt->getInt(self::TAG_OUTPUT_SIGNAL, 0);
	}

	protected function writeSaveData(CompoundTag $nbt) : void{
		$nbt->setInt(self::TAG_OUTPUT_SIGNAL, $this->signalStrength);
	}
}
