<?php

declare(strict_types=1);

namespace pocketmine\plugin;

use pocketmine\utils\EnumTrait;

/**
 * This doc-block is generated automatically, do not modify it manually.
 * This must be regenerated whenever registry members are added, removed or changed.
 * @see \pocketmine\utils\RegistryUtils::_generateMethodAnnotations()
 *
 * @method static PluginEnableOrder POSTWORLD()
 * @method static PluginEnableOrder STARTUP()
 */
final class PluginEnableOrder{
	use EnumTrait;

	protected static function setup() : void{
		self::registerAll(
			new self("startup"),
			new self("postworld")
		);
	}
}
