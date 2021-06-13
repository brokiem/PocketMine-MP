<?php

declare(strict_types=1);

namespace pocketmine\world\sound;

use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\LevelSoundEventPacket;

class RedstonePowerOffSound implements Sound{

	public function encode(?Vector3 $pos) : array{
		return [LevelSoundEventPacket::create(LevelSoundEventPacket::SOUND_POWER_OFF, $pos)];
	}
}
