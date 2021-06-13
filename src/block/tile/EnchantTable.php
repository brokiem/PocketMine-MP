<?php

declare(strict_types=1);

namespace pocketmine\block\tile;

class EnchantTable extends Spawnable implements Nameable{
	use NameableTrait {
		loadName as public readSaveData;
		saveName as writeSaveData;
	}

	public function getDefaultName() : string{
		return "Enchanting Table";
	}
}
