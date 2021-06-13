<?php

declare(strict_types=1);

namespace pocketmine\world\particle;

use pocketmine\block\Block;

abstract class MappingParticle implements Particle{

	/** @var int */
	protected $mappingProtocol;
	/** @var Block */
	protected $block;

	public function __construct(Block $b){
		$this->block = $b;
	}

	public function setMappingProtocol(int $mappingProtocol) : void{
		$this->mappingProtocol = $mappingProtocol;
	}
}
