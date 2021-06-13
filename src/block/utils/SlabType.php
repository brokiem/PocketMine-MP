<?php

declare(strict_types=1);

namespace pocketmine\block\utils;

use pocketmine\utils\EnumTrait;

/**
 * This doc-block is generated automatically, do not modify it manually.
 * This must be regenerated whenever registry members are added, removed or changed.
 * @see \pocketmine\utils\RegistryUtils::_generateMethodAnnotations()
 *
 * @method static SlabType BOTTOM()
 * @method static SlabType DOUBLE()
 * @method static SlabType TOP()
 */
final class SlabType{
	use EnumTrait;

	protected static function setup() : void{
		self::registerAll(
			new self("bottom"),
			new self("top"),
			new self("double")
		);
	}
}
