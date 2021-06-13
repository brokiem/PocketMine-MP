<?php

declare(strict_types=1);

namespace pocketmine\block\utils;

use pocketmine\utils\EnumTrait;

/**
 * This doc-block is generated automatically, do not modify it manually.
 * This must be regenerated whenever registry members are added, removed or changed.
 * @see \pocketmine\utils\RegistryUtils::_generateMethodAnnotations()
 *
 * @method static TreeType ACACIA()
 * @method static TreeType BIRCH()
 * @method static TreeType DARK_OAK()
 * @method static TreeType JUNGLE()
 * @method static TreeType OAK()
 * @method static TreeType SPRUCE()
 */
final class TreeType{
	use EnumTrait {
		register as Enum_register;
		__construct as Enum___construct;
	}

	/** @var TreeType[] */
	private static $numericIdMap = [];

	protected static function setup() : void{
		self::registerAll(
			new TreeType("oak", "Oak", 0),
			new TreeType("spruce", "Spruce", 1),
			new TreeType("birch", "Birch", 2),
			new TreeType("jungle", "Jungle", 3),
			new TreeType("acacia", "Acacia", 4),
			new TreeType("dark_oak", "Dark Oak", 5)
		);
	}

	protected static function register(TreeType $type) : void{
		self::Enum_register($type);
		self::$numericIdMap[$type->getMagicNumber()] = $type;
	}

	/**
	 * @internal
	 *
	 * @throws \InvalidArgumentException
	 */
	public static function fromMagicNumber(int $magicNumber) : TreeType{
		self::checkInit();
		if(!isset(self::$numericIdMap[$magicNumber])){
			throw new \InvalidArgumentException("Unknown tree type magic number $magicNumber");
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
