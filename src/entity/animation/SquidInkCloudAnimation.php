<?php

declare(strict_types=1);

namespace pocketmine\entity\animation;

use pocketmine\entity\Squid;
use pocketmine\network\mcpe\protocol\ActorEventPacket;

final class SquidInkCloudAnimation implements Animation{

	/** @var Squid */
	private $squid;

	public function __construct(Squid $squid){
		$this->squid = $squid;
	}

	public function encode() : array{
		return [
			ActorEventPacket::create($this->squid->getId(), ActorEventPacket::SQUID_INK_CLOUD, 0)
		];
	}
}
