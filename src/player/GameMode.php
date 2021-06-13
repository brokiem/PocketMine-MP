<?php

declare(strict_types=1);

namespace pocketmine\player;

use pocketmine\utils\EnumTrait;

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
		fromString as Enum_fromString;
	}

	/** @var self[] */
	protected static $aliasMap = [];
	/** @var self[] */
	protected static $magicNumberMap = [];

	protected static function setup() : void{
		self::registerAll(
			new self("survival", 0, "Survival", "gameMode.survival", ["s", "0"]),
			new self("creative", 1, "Creative", "gameMode.creative", ["c", "1"]),
			new self("adventure", 2, "Adventure", "gameMode.adventure", ["a", "2"]),
			new self("spectator", 3, "Spectator", "gameMode.spectator", ["v", "view", "3"])
		);
	}

	protected static function register(self $member) : void{
		self::Enum_register($member);
		self::$magicNumberMap[$member->getMagicNumber()] = $member;
		foreach($member->getAliases() as $alias){
			self::$aliasMap[$alias] = $member;
		}
	}

	public static function fromString(string $str) : self{
		self::checkInit();
		return self::$aliasMap[$str] ?? self::Enum_fromString($str);
	}

	/**
	 * @return GameMode
	 * @throws \InvalidArgumentException
	 */
	public static function fromMagicNumber(int $n) : self{
		self::checkInit();
		if(!isset(self::$magicNumberMap[$n])){
			throw new \InvalidArgumentException("No " . self::class . " enum member matches magic number $n");
		}
		return self::$magicNumberMap[$n];
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
	private function __construct(string $enumName, int $magicNumber, string $englishName, string $translationKey, array $aliases = []){
		$this->Enum___construct($enumName);
		$this->magicNumber = $magicNumber;
		$this->englishName = $englishName;
		$this->translationKey = $translationKey;
		$this->aliases = $aliases;
	}

	public function getMagicNumber() : int{
		return $this->magicNumber;
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
