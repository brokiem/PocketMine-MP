<?php

declare(strict_types=1);

namespace pocketmine\block\tile;

use pocketmine\nbt\tag\CompoundTag;
use pocketmine\network\mcpe\protocol\types\CacheableNbt;
use function get_class;

abstract class Spawnable extends Tile{
	/**
	 * @var CacheableNbt|null
	 * @phpstan-var CacheableNbt<\pocketmine\nbt\tag\CompoundTag>|null
	 */
	private $spawnCompoundCache = null;
	/** @var bool */
	private $dirty = true; //default dirty, until it's been spawned appropriately on the world

	/**
	 * Returns whether the tile needs to be respawned to viewers.
	 */
	public function isDirty() : bool{
		return $this->dirty;
	}

	public function setDirty(bool $dirty = true) : void{
		if($dirty){
			$this->spawnCompoundCache = null;
		}
		$this->dirty = $dirty;
	}

	/**
	 * Returns encoded NBT (varint, little-endian) used to spawn this tile to clients. Uses cache where possible,
	 * populates cache if it is null.
	 *
	 * @phpstan-return CacheableNbt<\pocketmine\nbt\tag\CompoundTag>
	 */
	final public function getSerializedSpawnCompound() : CacheableNbt{
		if($this->spawnCompoundCache === null){
			$this->spawnCompoundCache = new CacheableNbt($this->getSpawnCompound());
		}

		return $this->spawnCompoundCache;
	}

	final public function getSpawnCompound() : CompoundTag{
		$nbt = CompoundTag::create()
			->setString(self::TAG_ID, TileFactory::getInstance()->getSaveId(get_class($this))) //TODO: disassociate network ID from save ID
			->setInt(self::TAG_X, $this->pos->x)
			->setInt(self::TAG_Y, $this->pos->y)
			->setInt(self::TAG_Z, $this->pos->z);
		$this->addAdditionalSpawnData($nbt);
		return $nbt;
	}

	/**
	 * An extension to getSpawnCompound() for
	 * further modifying the generic tile NBT.
	 */
	abstract protected function addAdditionalSpawnData(CompoundTag $nbt) : void;
}
