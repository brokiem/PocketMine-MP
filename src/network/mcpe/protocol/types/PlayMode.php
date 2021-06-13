<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types;

/**
 * Enum used by PlayerAuthInputPacket. Most of these names don't make any sense, but that isn't surprising.
 */
final class PlayMode{

	private function __construct(){
		//NOOP
	}

	public const NORMAL = 0;
	public const TEASER = 1;
	public const SCREEN = 2;
	public const VIEWER = 3;
	public const VR = 4;
	public const PLACEMENT = 5;
	public const LIVING_ROOM = 6;
	public const EXIT_LEVEL = 7;
	public const EXIT_LEVEL_LIVING_ROOM = 8;

}
