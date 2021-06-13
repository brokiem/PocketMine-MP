<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\convert;

/**
 * Accessor for SkinAdapter
 */
class SkinAdapterSingleton{
	/** @var SkinAdapter|null */
	private static $skinAdapter = null;

	public static function get() : SkinAdapter{
		if(self::$skinAdapter === null){
			self::$skinAdapter = new LegacySkinAdapter();
		}
		return self::$skinAdapter;
	}

	public static function set(SkinAdapter $adapter) : void{
		self::$skinAdapter = $adapter;
	}
}
