<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types;

final class GameMode{

	private function __construct(){
		//NOOP
	}

	public const SURVIVAL = 0;
	public const CREATIVE = 1;
	public const ADVENTURE = 2;
	public const SURVIVAL_VIEWER = 3;
	public const CREATIVE_VIEWER = 4;
	public const DEFAULT = 5;
}
