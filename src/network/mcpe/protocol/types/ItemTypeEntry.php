<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types;

final class ItemTypeEntry{

	/** @var string */
	private $stringId;
	/** @var int */
	private $numericId;
	/** @var bool */
	private $componentBased;

	public function __construct(string $stringId, int $numericId, bool $componentBased){
		$this->stringId = $stringId;
		$this->numericId = $numericId;
		$this->componentBased = $componentBased;
	}

	public function getStringId() : string{ return $this->stringId; }

	public function getNumericId() : int{ return $this->numericId; }

	public function isComponentBased() : bool{ return $this->componentBased; }
}
