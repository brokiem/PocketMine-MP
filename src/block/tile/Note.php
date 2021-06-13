<?php

declare(strict_types=1);

namespace pocketmine\block\tile;

use pocketmine\block\Note as BlockNote;
use pocketmine\nbt\tag\CompoundTag;

/**
 * @deprecated
 */
class Note extends Tile{
	/** @var int */
	private $pitch = 0;

	public function readSaveData(CompoundTag $nbt) : void{
		if(($pitch = $nbt->getByte("note", $this->pitch)) > BlockNote::MIN_PITCH and $pitch <= BlockNote::MAX_PITCH){
			$this->pitch = $pitch;
		}
	}

	protected function writeSaveData(CompoundTag $nbt) : void{
		$nbt->setByte("note", $this->pitch);
	}

	public function getPitch() : int{
		return $this->pitch;
	}

	public function setPitch(int $pitch) : void{
		if($pitch < BlockNote::MIN_PITCH or $pitch > BlockNote::MAX_PITCH){
			throw new \InvalidArgumentException("Pitch must be in range " . BlockNote::MIN_PITCH . " - " . BlockNote::MAX_PITCH);
		}
		$this->pitch = $pitch;
	}
}
