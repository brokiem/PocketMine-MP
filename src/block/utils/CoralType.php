<?php

declare(strict_types=1);

namespace pocketmine\block\utils;

use pocketmine\utils\EnumTrait;

/**
 * This doc-block is generated automatically, do not modify it manually.
 * This must be regenerated whenever registry members are added, removed or changed.
 * @see \pocketmine\utils\RegistryUtils::_generateMethodAnnotations()
 *
 * @method static CoralType BRAIN()
 * @method static CoralType BUBBLE()
 * @method static CoralType FIRE()
 * @method static CoralType HORN()
 * @method static CoralType TUBE()
 */
final class CoralType{
	use EnumTrait {
		__construct as Enum___construct;
	}

	/** @var string */
	private $displayName;

	protected static function setup() : void{
		self::registerAll(
			new self("tube", "Tube"),
			new self("brain", "Brain"),
			new self("bubble", "Bubble"),
			new self("fire", "Fire"),
			new self("horn", "Horn"),
		);
	}

	private function __construct(string $name, string $displayName){
		$this->Enum___construct($name);
		$this->displayName = $displayName;
	}

	public function getDisplayName() : string{ return $this->displayName; }
}
