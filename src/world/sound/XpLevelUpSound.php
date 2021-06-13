<?php

declare(strict_types=1);

namespace pocketmine\world\sound;

use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\LevelSoundEventPacket;
use function intdiv;
use function min;

class XpLevelUpSound implements Sound{

	/** @var int */
	private $xpLevel;

	public function __construct(int $xpLevel){
		$this->xpLevel = $xpLevel;
	}

	public function getXpLevel() : int{
		return $this->xpLevel;
	}

	public function encode(?Vector3 $pos) : array{
		//No idea why such odd numbers, but this works...
		//TODO: check arbitrary volume
		return [LevelSoundEventPacket::create(LevelSoundEventPacket::SOUND_LEVELUP, $pos, 0x10000000 * intdiv(min(30, $this->xpLevel), 5))];
	}
}
