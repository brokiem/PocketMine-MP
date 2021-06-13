<?php

declare(strict_types=1);

namespace pocketmine\entity\animation;

use pocketmine\entity\projectile\Arrow;
use pocketmine\network\mcpe\protocol\ActorEventPacket;

class ArrowShakeAnimation implements Animation{

	/** @var Arrow */
	private $arrow;
	/** @var int */
	private $durationInTicks;

	public function __construct(Arrow $arrow, int $durationInTicks){
		$this->arrow = $arrow;
		$this->durationInTicks = $durationInTicks;
	}

	public function encode() : array{
		return [
			ActorEventPacket::create($this->arrow->getId(), ActorEventPacket::ARROW_SHAKE, $this->durationInTicks)
		];
	}
}
