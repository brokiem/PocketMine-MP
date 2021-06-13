<?php

declare(strict_types=1);

namespace pocketmine\world\sound;

use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\LevelSoundEventPacket;

/**
 * Played when a player attacks a mob, dealing damage.
 */
class EntityAttackSound implements Sound{

	public function encode(?Vector3 $pos) : array{
		return [LevelSoundEventPacket::create(
			LevelSoundEventPacket::SOUND_ATTACK_STRONG, //TODO: seems like ATTACK is dysfunctional
			$pos,
			-1,
			"minecraft:player"
		)];
	}
}
