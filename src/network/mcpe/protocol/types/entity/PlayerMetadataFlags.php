<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types\entity;

final class PlayerMetadataFlags{

	private function __construct(){
		//NOOP
	}

	public const SLEEP = 1;
	public const DEAD = 2; //TODO: CHECK
}
