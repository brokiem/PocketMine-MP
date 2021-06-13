<?php

declare(strict_types=1);

namespace pocketmine\block\tile;

use pocketmine\block\utils\DyeColor;
use pocketmine\data\bedrock\DyeColorIdMap;
use pocketmine\math\Vector3;
use pocketmine\nbt\tag\ByteTag;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\world\World;

class Bed extends Spawnable{
	public const TAG_COLOR = "color";
	/** @var DyeColor */
	private $color;

	public function __construct(World $world, Vector3 $pos){
		$this->color = DyeColor::RED();
		parent::__construct($world, $pos);
	}

	public function getColor() : DyeColor{
		return $this->color;
	}

	public function setColor(DyeColor $color) : void{
		$this->color = $color;
	}

	public function readSaveData(CompoundTag $nbt) : void{
		if(
			($colorTag = $nbt->getTag(self::TAG_COLOR)) instanceof ByteTag &&
			($color = DyeColorIdMap::getInstance()->fromId($colorTag->getValue())) !== null
		){
			$this->color = $color;
		}else{
			$this->color = DyeColor::RED(); //TODO: this should be an error, but we don't have the systems to handle it yet
		}
	}

	protected function writeSaveData(CompoundTag $nbt) : void{
		$nbt->setByte(self::TAG_COLOR, DyeColorIdMap::getInstance()->toId($this->color));
	}

	protected function addAdditionalSpawnData(CompoundTag $nbt) : void{
		$nbt->setByte(self::TAG_COLOR, DyeColorIdMap::getInstance()->toId($this->color));
	}
}
