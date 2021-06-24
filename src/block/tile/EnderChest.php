<?php

declare(strict_types=1);

namespace pocketmine\block\tile;

use pocketmine\nbt\tag\CompoundTag;

class EnderChest extends Spawnable{

	protected int $viewerCount = 0;

	public function getViewerCount() : int{
		return $this->viewerCount;
	}

	public function setViewerCount(int $viewerCount) : void{
		if($viewerCount < 0){
			throw new \InvalidArgumentException('Viewer count cannot be negative');
		}
		$this->viewerCount = $viewerCount;
	}

	public function readSaveData(CompoundTag $nbt) : void{

	}

	protected function writeSaveData(CompoundTag $nbt) : void{

	}

	protected function addAdditionalSpawnData(CompoundTag $nbt) : void{

	}
}
