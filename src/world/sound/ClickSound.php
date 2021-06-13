<?php

declare(strict_types=1);

namespace pocketmine\world\sound;

use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\LevelEventPacket;

class ClickSound implements Sound{

	/** @var float */
	private $pitch;

	public function __construct(float $pitch = 0){
		$this->pitch = $pitch;
	}

	public function getPitch() : float{
		return $this->pitch;
	}

	public function encode(?Vector3 $pos) : array{
		return [LevelEventPacket::create(LevelEventPacket::EVENT_SOUND_CLICK, (int) ($this->pitch * 1000), $pos)];
	}
}
