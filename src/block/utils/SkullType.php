<?php

declare(strict_types=1);

namespace pocketmine\block\utils;

use pocketmine\utils\EnumTrait;

/**
 * This doc-block is generated automatically, do not modify it manually.
 * This must be regenerated whenever registry members are added, removed or changed.
 * @see \pocketmine\utils\RegistryUtils::_generateMethodAnnotations()
 *
 * @method static SkullType CREEPER()
 * @method static SkullType DRAGON()
 * @method static SkullType PLAYER()
 * @method static SkullType SKELETON()
 * @method static SkullType WITHER_SKELETON()
 * @method static SkullType ZOMBIE()
 */
final class SkullType{
	use EnumTrait {
		register as Enum_register;
		__construct as Enum___construct;
	}

	/** @var SkullType[] */
	private static $numericIdMap = [];

	protected static function setup() : void{
		self::registerAll(
			new SkullType("skeleton", "Skeleton Skull", 0),
			new SkullType("wither_skeleton", "Wither Skeleton Skull", 1),
			new SkullType("zombie", "Zombie Head", 2),
			new SkullType("player", "Player Head", 3),
			new SkullType("creeper", "Creeper Head", 4),
			new SkullType("dragon", "Dragon Head", 5)
		);
	}

	protected static function register(SkullType $type) : void{
		self::Enum_register($type);
		self::$numericIdMap[$type->getMagicNumber()] = $type;
	}

	/**
	 * @internal
	 *
	 * @throws \InvalidArgumentException
	 */
	public static function fromMagicNumber(int $magicNumber) : SkullType{
		if(!isset(self::$numericIdMap[$magicNumber])){
			throw new \InvalidArgumentException("Unknown skull type magic number $magicNumber");
		}
		return self::$numericIdMap[$magicNumber];
	}

	/** @var string */
	private $displayName;
	/** @var int */
	private $magicNumber;

	private function __construct(string $enumName, string $displayName, int $magicNumber){
		$this->Enum___construct($enumName);
		$this->displayName = $displayName;
		$this->magicNumber = $magicNumber;
	}

	public function getDisplayName() : string{
		return $this->displayName;
	}

	public function getMagicNumber() : int{
		return $this->magicNumber;
	}
}
