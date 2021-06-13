<?php

declare(strict_types=1);

namespace pocketmine\world\sound;

use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\LevelEventPacket;

class AnvilBreakSound implements Sound{

	public function encode(?Vector3 $pos) : array{
		return [LevelEventPacket::create(LevelEventPacket::EVENT_SOUND_ANVIL_BREAK, 0, $pos)];
	}
}
