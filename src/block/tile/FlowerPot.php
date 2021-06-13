<?php

declare(strict_types=1);

namespace pocketmine\block\tile;

use pocketmine\block\Air;
use pocketmine\block\Block;
use pocketmine\block\BlockFactory;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\IntTag;
use pocketmine\nbt\tag\ShortTag;

/**
 * @deprecated
 * @see \pocketmine\block\FlowerPot
 */
class FlowerPot extends Spawnable{
	private const TAG_ITEM = "item";
	private const TAG_ITEM_DATA = "mData";

	/** @var Block|null */
	private $plant = null;

	public function readSaveData(CompoundTag $nbt) : void{
		if(($itemIdTag = $nbt->getTag(self::TAG_ITEM)) instanceof ShortTag and ($itemMetaTag = $nbt->getTag(self::TAG_ITEM_DATA)) instanceof IntTag){
			try{
				$this->setPlant(BlockFactory::getInstance()->get($itemIdTag->getValue(), $itemMetaTag->getValue()));
			}catch(\InvalidArgumentException $e){
				//noop
			}
		}else{
			//TODO: new PlantBlock tag
		}
	}

	protected function writeSaveData(CompoundTag $nbt) : void{
		if($this->plant !== null){
			$nbt->setShort(self::TAG_ITEM, $this->plant->getId());
			$nbt->setInt(self::TAG_ITEM_DATA, $this->plant->getMeta());
		}
	}

	public function getPlant() : ?Block{
		return $this->plant !== null ? clone $this->plant : null;
	}

	public function setPlant(?Block $plant) : void{
		if($plant === null or $plant instanceof Air){
			$this->plant = null;
		}else{
			$this->plant = clone $plant;
		}
	}

	protected function addAdditionalSpawnData(CompoundTag $nbt) : void{
		if($this->plant !== null){
			$nbt->setShort(self::TAG_ITEM, $this->plant->getId());
			$nbt->setInt(self::TAG_ITEM_DATA, $this->plant->getMeta());
		}
	}
}
