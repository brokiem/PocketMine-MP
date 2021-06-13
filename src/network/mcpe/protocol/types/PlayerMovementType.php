<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types;

final class PlayerMovementType{

	public const LEGACY = 0; //MovePlayerPacket
	public const SERVER_AUTHORITATIVE_V1 = 1; //PlayerAuthInputPacket
	public const SERVER_AUTHORITATIVE_V2_REWIND = 2; //PlayerAuthInputPacket + a bunch of junk that solves a nonexisting problem
}
