<?php

declare(strict_types=1);

namespace pocketmine\entity\animation;

use pocketmine\entity\Living;
use pocketmine\network\mcpe\protocol\ActorEventPacket;

final class RespawnAnimation implements Animation{

	/** @var Living */
	private $entity;

	public function __construct(Living $entity){
		$this->entity = $entity;
	}

	public function encode() : array{
		return [
			ActorEventPacket::create($this->entity->getId(), ActorEventPacket::RESPAWN, 0)
		];
	}
}
