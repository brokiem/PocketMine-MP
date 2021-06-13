<?php

declare(strict_types=1);

namespace pocketmine\entity\animation;

use pocketmine\entity\Living;
use pocketmine\network\mcpe\protocol\AnimatePacket;

final class CriticalHitAnimation implements Animation{

	/** @var Living */
	private $entity;

	public function __construct(Living $entity){
		$this->entity = $entity;
	}

	public function encode() : array{
		return [
			AnimatePacket::create($this->entity->getId(), AnimatePacket::ACTION_CRITICAL_HIT)
		];
	}
}
