<?php

declare(strict_types=1);

namespace pocketmine\block\tile;

use pocketmine\item\Item;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\StringTag;

/**
 * This trait implements most methods in the {@link Nameable} interface. It should only be used by Tiles.
 */
trait NameableTrait{
	/** @var string|null */
	private $customName = null;

	abstract public function getDefaultName() : string;

	public function getName() : string{
		return $this->customName ?? $this->getDefaultName();
	}

	public function setName(string $name) : void{
		if($name === ""){
			$this->customName = null;
		}else{
			$this->customName = $name;
		}
	}

	public function hasName() : bool{
		return $this->customName !== null;
	}

	public function addAdditionalSpawnData(CompoundTag $nbt) : void{
		if($this->customName !== null){
			$nbt->setString(Nameable::TAG_CUSTOM_NAME, $this->customName);
		}
	}

	protected function loadName(CompoundTag $tag) : void{
		if(($customNameTag = $tag->getTag(Nameable::TAG_CUSTOM_NAME)) instanceof StringTag){
			$this->customName = $customNameTag->getValue();
		}
	}

	protected function saveName(CompoundTag $tag) : void{
		if($this->customName !== null){
			$tag->setString(Nameable::TAG_CUSTOM_NAME, $this->customName);
		}
	}

	/**
	 * @see Tile::copyDataFromItem()
	 */
	public function copyDataFromItem(Item $item) : void{
		parent::copyDataFromItem($item);
		if($item->hasCustomName()){ //this should take precedence over saved NBT
			$this->setName($item->getCustomName());
		}
	}
}
