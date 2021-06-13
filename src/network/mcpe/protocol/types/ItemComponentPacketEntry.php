<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types;

use pocketmine\nbt\tag\CompoundTag;

final class ItemComponentPacketEntry{

	/** @var string */
	private $name;
	/** @var CompoundTag */
	private $componentNbt;

	public function __construct(string $name, CompoundTag $componentNbt){
		$this->name = $name;
		$this->componentNbt = $componentNbt;
	}

	public function getName() : string{ return $this->name; }

	public function getComponentNbt() : CompoundTag{ return $this->componentNbt; }
}
