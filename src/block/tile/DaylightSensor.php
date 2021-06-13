<?php

declare(strict_types=1);

namespace pocketmine\block\tile;

use pocketmine\nbt\tag\CompoundTag;

/**
 * @deprecated
 * As per the wiki, this is an old hack to force daylight sensors to get updated every game tick. This is necessary to
 * ensure that the daylight sensor's power output is always up to date with the current world time.
 * It's theoretically possible to implement this without a blockentity, but this is here to ensure that vanilla can
 * understand daylight sensors in worlds created by PM.
 */
class DaylightSensor extends Tile{

	public function readSaveData(CompoundTag $nbt) : void{

	}

	protected function writeSaveData(CompoundTag $nbt) : void{

	}
}
