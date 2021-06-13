<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types;

final class PlayerPermissions{

	private function __construct(){
		//NOOP
	}

	public const CUSTOM = 3;
	public const OPERATOR = 2;
	public const MEMBER = 1;
	public const VISITOR = 0;

}
