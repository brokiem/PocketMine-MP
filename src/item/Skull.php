<?php

declare(strict_types=1);

namespace pocketmine\item;

use pocketmine\block\Block;
use pocketmine\block\utils\SkullType;
use pocketmine\block\VanillaBlocks;

class Skull extends Item{

	/** @var SkullType */
	private $skullType;

	public function __construct(ItemIdentifier $identifier, string $name, SkullType $skullType){
		parent::__construct($identifier, $name);
		$this->skullType = $skullType;
	}

	public function getBlock(?int $clickedFace = null) : Block{
		return VanillaBlocks::MOB_HEAD();
	}

	public function getSkullType() : SkullType{
		return $this->skullType;
	}
}
