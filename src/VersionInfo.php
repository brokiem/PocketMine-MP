<?php

declare(strict_types=1);

namespace pocketmine;

use pocketmine\utils\Git;
use pocketmine\utils\VersionString;
use function str_repeat;

final class VersionInfo{
	public const NAME = "PocketMine-MP";
	public const BASE_VERSION = "4.0.0";
	public const IS_DEVELOPMENT_BUILD = true;
	public const BUILD_NUMBER = 0;

	private function __construct(){
		//NOOP
	}

	/** @var string|null */
	private static $gitHash = null;

	public static function getGitHash() : string{
		if(self::$gitHash === null){
			$gitHash = str_repeat("00", 20);

			if(\Phar::running(true) === ""){
				$gitHash = Git::getRepositoryStatePretty(\pocketmine\PATH);
			}else{
				$phar = new \Phar(\Phar::running(false));
				$meta = $phar->getMetadata();
				if(isset($meta["git"])){
					$gitHash = $meta["git"];
				}
			}

			self::$gitHash = $gitHash;
		}

		return self::$gitHash;
	}

	/** @var VersionString|null */
	private static $fullVersion = null;

	public static function getVersionObj() : VersionString{
		if(self::$fullVersion === null){
			self::$fullVersion = new VersionString(self::BASE_VERSION, self::IS_DEVELOPMENT_BUILD, self::BUILD_NUMBER);
		}
		return self::$fullVersion;
	}
}
