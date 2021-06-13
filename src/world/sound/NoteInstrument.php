<?php

declare(strict_types=1);

namespace pocketmine\world\sound;

use pocketmine\utils\EnumTrait;

/**
 * This doc-block is generated automatically, do not modify it manually.
 * This must be regenerated whenever registry members are added, removed or changed.
 * @see \pocketmine\utils\RegistryUtils::_generateMethodAnnotations()
 *
 * @method static NoteInstrument BASS_DRUM()
 * @method static NoteInstrument CLICKS_AND_STICKS()
 * @method static NoteInstrument DOUBLE_BASS()
 * @method static NoteInstrument PIANO()
 * @method static NoteInstrument SNARE()
 */
final class NoteInstrument{
	use EnumTrait {
		__construct as Enum___construct;
	}

	protected static function setup() : void{
		self::registerAll(
			new self("piano", 0),
			new self("bass_drum", 1),
			new self("snare", 2),
			new self("clicks_and_sticks", 3),
			new self("double_bass", 4)
		);
	}

	/** @var int */
	private $magicNumber;

	private function __construct(string $name, int $magicNumber){
		$this->Enum___construct($name);
		$this->magicNumber = $magicNumber;
	}

	public function getMagicNumber() : int{
		return $this->magicNumber;
	}
}
