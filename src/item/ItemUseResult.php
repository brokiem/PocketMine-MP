<?php

declare(strict_types=1);

namespace pocketmine\item;

use pocketmine\utils\EnumTrait;

/**
 * This doc-block is generated automatically, do not modify it manually.
 * This must be regenerated whenever registry members are added, removed or changed.
 * @see \pocketmine\utils\RegistryUtils::_generateMethodAnnotations()
 *
 * @method static ItemUseResult FAIL()
 * @method static ItemUseResult NONE()
 * @method static ItemUseResult SUCCESS()
 */
final class ItemUseResult{
	use EnumTrait;

	protected static function setup() : void{
		self::registerAll(
			new self("none"),
			new self("fail"),
			new self("success")
		);
	}
}
