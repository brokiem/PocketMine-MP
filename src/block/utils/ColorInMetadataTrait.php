<?php

declare(strict_types=1);

namespace pocketmine\block\utils;

use pocketmine\block\Block;
use pocketmine\data\bedrock\DyeColorIdMap;

trait ColorInMetadataTrait{
	use ColoredTrait;

	/**
	 * @see Block::readStateFromData()
	 */
	public function readStateFromData(int $id, int $stateMeta) : void{
		$color = DyeColorIdMap::getInstance()->fromId($stateMeta);
		if($color === null){
			throw new InvalidBlockStateException("No dye colour corresponds to ID $stateMeta");
		}
		$this->color = $color;
	}

	/**
	 * @see Block::writeStateToMeta()
	 */
	protected function writeStateToMeta() : int{
		return DyeColorIdMap::getInstance()->toId($this->color);
	}

	/**
	 * @see Block::getStateBitmask()
	 */
	public function getStateBitmask() : int{
		return 0b1111;
	}

	/**
	 * @see Block::getNonPersistentStateBitmask()
	 */
	public function getNonPersistentStateBitmask() : int{
		return 0;
	}
}
