<?php

declare(strict_types=1);

namespace pocketmine\block\utils;

use pocketmine\utils\EnumTrait;

/**
 * This doc-block is generated automatically, do not modify it manually.
 * This must be regenerated whenever registry members are added, removed or changed.
 * @see \pocketmine\utils\RegistryUtils::_generateMethodAnnotations()
 *
 * @method static StairShape INNER_LEFT()
 * @method static StairShape INNER_RIGHT()
 * @method static StairShape OUTER_LEFT()
 * @method static StairShape OUTER_RIGHT()
 * @method static StairShape STRAIGHT()
 */
final class StairShape{
	use EnumTrait;

	protected static function setup() : void{
		self::registerAll(
			new self("straight"),
			new self("inner_left"),
			new self("inner_right"),
			new self("outer_left"),
			new self("outer_right")
		);
	}
}
