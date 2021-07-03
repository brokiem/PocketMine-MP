<?php

declare(strict_types=1);

namespace pocketmine\player;

use pocketmine\utils\EnumTrait;
use function mb_strtolower;

/**
 * This doc-block is generated automatically, do not modify it manually.
 * This must be regenerated whenever registry members are added, removed or changed.
 * @see \pocketmine\utils\RegistryUtils::_generateMethodAnnotations()
 *
 * @method static GameMode ADVENTURE()
 * @method static GameMode CREATIVE()
 * @method static GameMode SPECTATOR()
 * @method static GameMode SURVIVAL()
 */
final class GameMode{
	use EnumTrait {
		__construct as Enum___construct;
		register as Enum_register;
	}

	/** @var self[] */
	protected static $aliasMap = [];

	protected static function setup() : void{
		self::registerAll(
			new self("survival", "Survival", "gameMode.survival", ["survival", "s", "0"]),
			new self("creative", "Creative", "gameMode.creative", ["creative", "c", "1"]),
			new self("adventure", "Adventure", "gameMode.adventure", ["adventure", "a", "2"]),
			new self("spectator", "Spectator", "gameMode.spectator", ["spectator", "v", "view", "3"])
		);
	}

	protected static function register(self $member) : void{
		self::Enum_register($member);
		foreach($member->getAliases() as $alias){
			self::$aliasMap[mb_strtolower($alias)] = $member;
		}
	}

	public static function fromString(string $str) : ?self{
		self::checkInit();
		return self::$aliasMap[mb_strtolower($str)] ?? null;
	}

	/** @var int */
	private $magicNumber;
	/** @var string */
	private $englishName;
	/** @var string */
	private $translationKey;
	/** @var string[] */
	private $aliases;

	/**
	 * @param string[] $aliases
	 */
	private function __construct(string $enumName, string $englishName, string $translationKey, array $aliases = []){
		$this->Enum___construct($enumName);
		$this->englishName = $englishName;
		$this->translationKey = $translationKey;
		$this->aliases = $aliases;
	}

	public function getEnglishName() : string{
		return $this->englishName;
	}

	public function getTranslationKey() : string{
		return "%" . $this->translationKey;
	}

	/**
	 * @return string[]
	 */
	public function getAliases() : array{
		return $this->aliases;
	}

	//TODO: ability sets per gamemode
}
