<?php

declare(strict_types=1);

namespace pocketmine\block\tile;

use pocketmine\block\inventory\BarrelInventory;
use pocketmine\math\Vector3;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\world\World;

class Barrel extends Spawnable implements Container, Nameable{
	use NameableTrait;
	use ContainerTrait;

	/** @var BarrelInventory */
	protected $inventory;

	public function __construct(World $world, Vector3 $pos){
		parent::__construct($world, $pos);
		$this->inventory = new BarrelInventory($this->pos);
	}

	public function readSaveData(CompoundTag $nbt) : void{
		$this->loadName($nbt);
		$this->loadItems($nbt);
	}

	protected function writeSaveData(CompoundTag $nbt) : void{
		$this->saveName($nbt);
		$this->saveItems($nbt);
	}

	public function close() : void{
		if(!$this->closed){
			$this->inventory->removeAllViewers();
			$this->inventory = null;
			parent::close();
		}
	}

	/**
	 * @return BarrelInventory
	 */
	public function getInventory(){
		return $this->inventory;
	}

	/**
	 * @return BarrelInventory
	 */
	public function getRealInventory(){
		return $this->inventory;
	}

	public function getDefaultName() : string{
		return "Barrel";
	}
}
