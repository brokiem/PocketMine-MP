<?php

declare(strict_types=1);

namespace pocketmine\world\sound;

abstract class MappingSound implements Sound{

	/** @var int */
	protected $mappingProtocol;

	public function setMappingProtocol(int $mappingProtocol) : void{
		$this->mappingProtocol = $mappingProtocol;
	}
}
