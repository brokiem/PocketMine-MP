<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\convert;

use pocketmine\nbt\tag\CompoundTag;

final class R12ToCurrentBlockMapEntry{

	/** @var string */
	private $id;
	/** @var int */
	private $meta;
	/** @var CompoundTag */
	private $blockState;

	public function __construct(string $id, int $meta, CompoundTag $blockState){
		$this->id = $id;
		$this->meta = $meta;
		$this->blockState = $blockState;
	}

	public function getId() : string{
		return $this->id;
	}

	public function getMeta() : int{
		return $this->meta;
	}

	public function getBlockState() : CompoundTag{
		return $this->blockState;
	}

	public function __toString(){
		return "id=$this->id, meta=$this->meta, nbt=$this->blockState";
	}
}
