<?php

declare(strict_types=1);

namespace pocketmine\world\sound;

use pocketmine\block\utils\RecordType;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\LevelSoundEventPacket;

class RecordSound implements Sound{

	/** @var RecordType */
	private $recordType;

	public function __construct(RecordType $recordType){
		$this->recordType = $recordType;
	}

	public function encode(?Vector3 $pos) : array{
		return [LevelSoundEventPacket::create($this->recordType->getSoundId(), $pos)];
	}
}
