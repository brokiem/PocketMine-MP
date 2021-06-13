<?php

declare(strict_types=1);

namespace pocketmine\world\sound;

use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\LevelSoundEventPacket;

class NoteSound implements Sound{

	/** @var NoteInstrument */
	private $instrument;
	/** @var int */
	private $note;

	public function __construct(NoteInstrument $instrument, int $note){
		if($note < 0 or $note > 255){
			throw new \InvalidArgumentException("Note $note is outside accepted range");
		}
		$this->instrument = $instrument;
		$this->note = $note;
	}

	public function encode(?Vector3 $pos) : array{
		return [LevelSoundEventPacket::create(LevelSoundEventPacket::SOUND_NOTE, $pos, ($this->instrument->getMagicNumber() << 8) | $this->note)];
	}
}
