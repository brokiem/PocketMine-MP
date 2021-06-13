<?php

declare(strict_types=1);

namespace pocketmine\world\particle;

use pocketmine\block\Block;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\convert\RuntimeBlockMapping;
use pocketmine\network\mcpe\protocol\LevelEventPacket;

/**
 * This particle appears when a player is attacking a block face in survival mode attempting to break it.
 */
class BlockPunchParticle extends MappingParticle{

	/** @var int */
	private $face;

	public function __construct(Block $block, int $face){
		parent::__construct($block);
		$this->face = $face;
	}

	public function encode(Vector3 $pos) : array{
		return [LevelEventPacket::create(LevelEventPacket::EVENT_PARTICLE_PUNCH_BLOCK, RuntimeBlockMapping::getInstance()->toRuntimeId($this->block->getFullId(), $this->mappingProtocol) | ($this->face << 24), $pos)];
	}
}
