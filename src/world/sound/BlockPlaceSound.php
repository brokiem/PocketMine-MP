<?php

declare(strict_types=1);

namespace pocketmine\world\sound;

use pocketmine\block\Block;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\convert\RuntimeBlockMapping;
use pocketmine\network\mcpe\protocol\LevelSoundEventPacket;

class BlockPlaceSound extends MappingSound{

	/** @var Block */
	private $block;

	public function __construct(Block $block){
		$this->block = $block;
	}

	public function encode(?Vector3 $pos) : array{
		return [LevelSoundEventPacket::create(LevelSoundEventPacket::SOUND_PLACE, $pos, RuntimeBlockMapping::getInstance()->toRuntimeId($this->block->getFullId(), $this->mappingProtocol))];
	}
}
