<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types;

final class InputMode{

	private function __construct(){
		//NOOP
	}

	public const MOUSE_KEYBOARD = 1;
	public const TOUCHSCREEN = 2;
	public const GAME_PAD = 3;
	public const MOTION_CONTROLLER = 4;
}
