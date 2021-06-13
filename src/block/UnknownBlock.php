<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\item\Item;

class UnknownBlock extends Transparent{

	public function __construct(BlockIdentifier $idInfo, BlockBreakInfo $breakInfo){
		parent::__construct($idInfo, "Unknown", $breakInfo);
	}

	public function canBePlaced() : bool{
		return false;
	}

	public function getDrops(Item $item) : array{
		return [];
	}
}
