<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types;

final class MultiplayerGameVisibility{

	private function __construct(){
		//NOOP
	}

	public const NONE = 0;
	public const INVITE = 1;
	public const FRIENDS = 2;
	public const FRIENDS_OF_FRIENDS = 3;
	public const PUBLIC = 4;
}
