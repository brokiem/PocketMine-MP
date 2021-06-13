<?php

declare(strict_types=1);

namespace pocketmine\block\tile;

use pocketmine\item\Item;
use pocketmine\item\Record;
use pocketmine\nbt\tag\CompoundTag;

class Jukebox extends Spawnable{
	private const TAG_RECORD = "RecordItem"; //Item CompoundTag

	/** @var Record|null */
	private $record = null;

	public function getRecord() : ?Record{
		return $this->record;
	}

	public function setRecord(?Record $record) : void{
		$this->record = $record;
	}

	public function readSaveData(CompoundTag $nbt) : void{
		if(($tag = $nbt->getCompoundTag(self::TAG_RECORD)) !== null){
			$record = Item::nbtDeserialize($tag);
			if($record instanceof Record){
				$this->record = $record;
			}
		}
	}

	protected function writeSaveData(CompoundTag $nbt) : void{
		if($this->record !== null){
			$nbt->setTag(self::TAG_RECORD, $this->record->nbtSerialize());
		}
	}

	protected function addAdditionalSpawnData(CompoundTag $nbt) : void{
		//this is needed for the note particles to show on the client side
		if($this->record !== null){
			$nbt->setTag(self::TAG_RECORD, $this->record->nbtSerialize());
		}
	}
}
