<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types;

use pocketmine\nbt\tag\CompoundTag;

final class BlockPaletteEntry{

	/** @var string */
	private $name;
	/** @var CompoundTag */
	private $states;

	public function __construct(string $name, CompoundTag $states){
		$this->name = $name;
		$this->states = $states;
	}

	public function getName() : string{ return $this->name; }

	public function getStates() : CompoundTag{ return $this->states; }
}
