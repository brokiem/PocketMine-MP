<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types\command;

use Ramsey\Uuid\UuidInterface;

class CommandOriginData{
	public const ORIGIN_PLAYER = 0;
	public const ORIGIN_BLOCK = 1;
	public const ORIGIN_MINECART_BLOCK = 2;
	public const ORIGIN_DEV_CONSOLE = 3;
	public const ORIGIN_TEST = 4;
	public const ORIGIN_AUTOMATION_PLAYER = 5;
	public const ORIGIN_CLIENT_AUTOMATION = 6;
	public const ORIGIN_DEDICATED_SERVER = 7;
	public const ORIGIN_ENTITY = 8;
	public const ORIGIN_VIRTUAL = 9;
	public const ORIGIN_GAME_ARGUMENT = 10;
	public const ORIGIN_ENTITY_SERVER = 11; //???

	/** @var int */
	public $type;
	/** @var UuidInterface */
	public $uuid;

	/** @var string */
	public $requestId;

	/** @var int */
	public $playerEntityUniqueId;
}
