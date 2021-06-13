<?php

declare(strict_types=1);

namespace pocketmine\entity\animation;

use pocketmine\entity\Living;
use pocketmine\network\mcpe\protocol\ActorEventPacket;

final class ArmSwingAnimation implements Animation{

	/** @var Living */
	private $entity; //TODO: not sure if this should be constrained to humanoids, but we don't have any concept of that right now

	public function __construct(Living $entity){
		$this->entity = $entity;
	}

	public function encode() : array{
		return [
			ActorEventPacket::create($this->entity->getId(), ActorEventPacket::ARM_SWING, 0)
		];
	}
}
