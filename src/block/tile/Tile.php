<?php

declare(strict_types=1);

/**
 * All the Tile classes and related classes
 */

namespace pocketmine\block\tile;

use pocketmine\block\Block;
use pocketmine\item\Item;
use pocketmine\math\Vector3;
use pocketmine\nbt\NbtDataException;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\timings\Timings;
use pocketmine\timings\TimingsHandler;
use pocketmine\world\Position;
use pocketmine\world\World;
use function get_class;

abstract class Tile{

	public const TAG_ID = "id";
	public const TAG_X = "x";
	public const TAG_Y = "y";
	public const TAG_Z = "z";

	/** @var Position */
	protected $pos;
	/** @var bool */
	public $closed = false;
	/** @var TimingsHandler */
	protected $timings;

	public function __construct(World $world, Vector3 $pos){
		$this->pos = Position::fromObject($pos, $world);
		$this->timings = Timings::getTileEntityTimings($this);
	}

	/**
	 * @internal
	 * @throws NbtDataException
	 * Reads additional data from the CompoundTag on tile creation.
	 */
	abstract public function readSaveData(CompoundTag $nbt) : void;

	/**
	 * Writes additional save data to a CompoundTag, not including generic things like ID and coordinates.
	 */
	abstract protected function writeSaveData(CompoundTag $nbt) : void;

	public function saveNBT() : CompoundTag{
		$nbt = CompoundTag::create()
			->setString(self::TAG_ID, TileFactory::getInstance()->getSaveId(get_class($this)))
			->setInt(self::TAG_X, $this->pos->getFloorX())
			->setInt(self::TAG_Y, $this->pos->getFloorY())
			->setInt(self::TAG_Z, $this->pos->getFloorZ());
		$this->writeSaveData($nbt);

		return $nbt;
	}

	public function getCleanedNBT() : ?CompoundTag{
		$this->writeSaveData($tag = new CompoundTag());
		return $tag->getCount() > 0 ? $tag : null;
	}

	/**
	 * @internal
	 *
	 * @throws \RuntimeException
	 */
	public function copyDataFromItem(Item $item) : void{
		if(($blockNbt = $item->getCustomBlockData()) !== null){ //TODO: check item root tag (MCPE doesn't use BlockEntityTag)
			$this->readSaveData($blockNbt);
		}
	}

	public function getBlock() : Block{
		return $this->pos->getWorld()->getBlock($this->pos);
	}

	public function getPos() : Position{
		return $this->pos;
	}

	public function isClosed() : bool{
		return $this->closed;
	}

	public function __destruct(){
		$this->close();
	}

	/**
	 * Called when the tile's block is destroyed.
	 */
	final public function onBlockDestroyed() : void{
		$this->onBlockDestroyedHook();
		$this->close();
	}

	/**
	 * Override this method to do actions you need to do when this tile is destroyed due to block being broken.
	 */
	protected function onBlockDestroyedHook() : void{

	}

	public function close() : void{
		if(!$this->closed){
			$this->closed = true;

			if($this->pos->isValid()){
				$this->pos->getWorld()->removeTile($this);
			}
			$this->pos = null;
		}
	}
}
