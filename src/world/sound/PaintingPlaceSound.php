<?php

declare(strict_types=1);

namespace pocketmine\world\sound;

use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\LevelEventPacket;

class PaintingPlaceSound implements Sound{

	public function encode(?Vector3 $pos) : array{
		//item frame and painting have the same sound
		return [LevelEventPacket::create(LevelEventPacket::EVENT_SOUND_ITEMFRAME_PLACE, 0, $pos)];
	}
}
