<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\item\Item;

final class InfestedStone extends Opaque{

	private int $imitated;

	public function __construct(BlockIdentifier $idInfo, string $name, BlockBreakInfo $breakInfo, Block $imitated){
		parent::__construct($idInfo, $name, $breakInfo);
		$this->imitated = $imitated->getFullId();
	}

	public function getImitatedBlock() : Block{
		return BlockFactory::getInstance()->fromFullBlock($this->imitated);
	}

	public function getDropsForCompatibleTool(Item $item) : array{
		return [];
	}

	public function getSilkTouchDrops(Item $item) : array{
		return [$this->getImitatedBlock()->asItem()];
	}

	public function isAffectedBySilkTouch() : bool{
		return true;
	}

	//TODO
}
