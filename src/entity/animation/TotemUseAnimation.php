<?php

declare(strict_types=1);

namespace pocketmine\entity\animation;

use pocketmine\entity\Human;
use pocketmine\network\mcpe\protocol\ActorEventPacket;

final class TotemUseAnimation implements Animation{

	/** @var Human */
	private $human;

	public function __construct(Human $human){
		//TODO: check if this can be expanded to more than just humans
		$this->human = $human;
	}

	public function encode() : array{
		return [
			ActorEventPacket::create($this->human->getId(), ActorEventPacket::CONSUME_TOTEM, 0)
		];
	}
}
