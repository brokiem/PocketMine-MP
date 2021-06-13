<?php

declare(strict_types=1);

namespace pocketmine\player;

use pocketmine\utils\EnumTrait;

/**
 * This doc-block is generated automatically, do not modify it manually.
 * This must be regenerated whenever registry members are added, removed or changed.
 * @see \pocketmine\utils\RegistryUtils::_generateMethodAnnotations()
 *
 * @method static UsedChunkStatus NEEDED()
 * @method static UsedChunkStatus REQUESTED()
 * @method static UsedChunkStatus SENT()
 */
final class UsedChunkStatus{
	use EnumTrait;

	protected static function setup() : void{
		self::registerAll(
			new self("NEEDED"),
			new self("REQUESTED"),
			new self("SENT")
		);
	}
}
