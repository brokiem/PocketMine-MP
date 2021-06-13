<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types;

final class GameRuleType{

	private function __construct(){
		//NOOP
	}

	public const BOOL = 1;
	public const INT = 2;
	public const FLOAT = 3;
}
