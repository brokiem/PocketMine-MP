<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\block\tile\Jukebox as JukeboxTile;
use pocketmine\item\Item;
use pocketmine\item\Record;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\world\sound\RecordSound;
use pocketmine\world\sound\RecordStopSound;

class Jukebox extends Opaque{

	private ?Record $record = null;

	public function getFuelTime() : int{
		return 300;
	}

	public function onInteract(Item $item, int $face, Vector3 $clickVector, ?Player $player = null) : bool{
		if($player instanceof Player){
			if($this->record !== null){
				$this->ejectRecord();
			}elseif($item instanceof Record){
				$player->sendJukeboxPopup("record.nowPlaying", ["%" . $item->getRecordType()->getTranslationKey()]);
				$this->insertRecord($item->pop());
			}
		}

		$this->pos->getWorld()->setBlock($this->pos, $this);

		return true;
	}

	public function getRecord() : ?Record{
		return $this->record;
	}

	public function ejectRecord() : void{
		if($this->record !== null){
			$this->getPos()->getWorld()->dropItem($this->getPos()->add(0.5, 1, 0.5), $this->record);
			$this->record = null;
			$this->stopSound();
		}
	}

	public function insertRecord(Record $record) : void{
		if($this->record === null){
			$this->record = $record;
			$this->startSound();
		}
	}

	public function startSound() : void{
		if($this->record !== null){
			$this->getPos()->getWorld()->addSound($this->getPos(), new RecordSound($this->record->getRecordType()));
		}
	}

	public function stopSound() : void{
		$this->getPos()->getWorld()->addSound($this->getPos(), new RecordStopSound());
	}

	public function onBreak(Item $item, ?Player $player = null) : bool{
		$this->stopSound();
		return parent::onBreak($item, $player);
	}

	public function getDropsForCompatibleTool(Item $item) : array{
		$drops = parent::getDropsForCompatibleTool($item);
		if($this->record !== null){
			$drops[] = $this->record;
		}
		return $drops;
	}

	public function readStateFromWorld() : void{
		parent::readStateFromWorld();
		$jukebox = $this->pos->getWorld()->getTile($this->pos);
		if($jukebox instanceof JukeboxTile){
			$this->record = $jukebox->getRecord();
		}
	}

	public function writeStateToWorld() : void{
		parent::writeStateToWorld();
		$jukebox = $this->pos->getWorld()->getTile($this->pos);
		if($jukebox instanceof JukeboxTile){
			$jukebox->setRecord($this->record);
		}
	}

	//TODO: Jukebox has redstone effects, they are not implemented.
}
