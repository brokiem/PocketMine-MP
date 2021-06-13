<?php

declare(strict_types=1);

namespace pocketmine\world\sound;

use pocketmine\block\Block;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\convert\RuntimeBlockMapping;
use pocketmine\network\mcpe\protocol\LevelSoundEventPacket;

/**
 * Played when a player attacks a block in survival, attempting to break it.
 */
class BlockPunchSound extends MappingSound{

	/** @var Block */
	private $block;

	public function __construct(Block $block){
		$this->block = $block;
	}

	public function encode(?Vector3 $pos) : array{
		return [LevelSoundEventPacket::create(
			LevelSoundEventPacket::SOUND_HIT,
			$pos,
			RuntimeBlockMapping::getInstance()->toRuntimeId($this->block->getFullId(), $this->mappingProtocol)
		)];
	}
}
