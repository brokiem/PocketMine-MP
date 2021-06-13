<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types;

final class UIProfile{

	private function __construct(){
		//NOOP
	}

	public const CLASSIC = 0;
	public const POCKET = 1;
}
