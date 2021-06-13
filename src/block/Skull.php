<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\block\tile\Skull as TileSkull;
use pocketmine\block\utils\BlockDataSerializer;
use pocketmine\block\utils\SkullType;
use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use pocketmine\item\ItemIds;
use pocketmine\item\Skull as ItemSkull;
use pocketmine\math\AxisAlignedBB;
use pocketmine\math\Facing;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\world\BlockTransaction;
use function assert;
use function floor;

class Skull extends Flowable{

	protected SkullType $skullType;

	protected int $facing = Facing::NORTH;
	protected bool $noDrops = false;
	protected int $rotation = 0; //TODO: split this into floor skull and wall skull handling

	public function __construct(BlockIdentifier $idInfo, string $name, BlockBreakInfo $breakInfo){
		$this->skullType = SkullType::SKELETON(); //TODO: this should be a parameter
		parent::__construct($idInfo, $name, $breakInfo);
	}

	protected function writeStateToMeta() : int{
		return ($this->facing === Facing::UP ? 1 : BlockDataSerializer::writeHorizontalFacing($this->facing)) |
			($this->noDrops ? BlockLegacyMetadata::SKULL_FLAG_NO_DROPS : 0);
	}

	public function readStateFromData(int $id, int $stateMeta) : void{
		$this->facing = $stateMeta === 1 ? Facing::UP : BlockDataSerializer::readHorizontalFacing($stateMeta);
		$this->noDrops = ($stateMeta & BlockLegacyMetadata::SKULL_FLAG_NO_DROPS) !== 0;
	}

	public function getStateBitmask() : int{
		return 0b1111;
	}

	public function readStateFromWorld() : void{
		parent::readStateFromWorld();
		$tile = $this->pos->getWorld()->getTile($this->pos);
		if($tile instanceof TileSkull){
			$this->skullType = $tile->getSkullType();
			$this->rotation = $tile->getRotation();
		}
	}

	public function writeStateToWorld() : void{
		parent::writeStateToWorld();
		//extra block properties storage hack
		$tile = $this->pos->getWorld()->getTile($this->pos);
		assert($tile instanceof TileSkull);
		$tile->setRotation($this->rotation);
		$tile->setSkullType($this->skullType);
	}

	public function getSkullType() : SkullType{
		return $this->skullType;
	}

	/** @return $this */
	public function setSkullType(SkullType $skullType) : self{
		$this->skullType = $skullType;
		return $this;
	}

	public function getFacing() : int{ return $this->facing; }

	/** @return $this */
	public function setFacing(int $facing) : self{
		if($facing === Facing::DOWN){
			throw new \InvalidArgumentException("Skull may not face DOWN");
		}
		$this->facing = $facing;
		return $this;
	}

	public function getRotation() : int{ return $this->rotation; }

	/** @return $this */
	public function setRotation(int $rotation) : self{
		if($rotation < 0 || $rotation > 15){
			throw new \InvalidArgumentException("Rotation must be a value between 0 and 15");
		}
		$this->rotation = $rotation;
		return $this;
	}

	public function isNoDrops() : bool{ return $this->noDrops; }

	/** @return $this */
	public function setNoDrops(bool $noDrops) : self{
		$this->noDrops = $noDrops;
		return $this;
	}

	/**
	 * @return AxisAlignedBB[]
	 */
	protected function recalculateCollisionBoxes() : array{
		//TODO: different bounds depending on attached face
		return [AxisAlignedBB::one()->contract(0.25, 0, 0.25)->trim(Facing::UP, 0.5)];
	}

	public function place(BlockTransaction $tx, Item $item, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector, ?Player $player = null) : bool{
		if($face === Facing::DOWN){
			return false;
		}

		$this->facing = $face;
		if($item instanceof ItemSkull){
			$this->skullType = $item->getSkullType(); //TODO: the item should handle this, but this hack is currently needed because of tile mess
		}
		if($player !== null and $face === Facing::UP){
			$this->rotation = ((int) floor(($player->getLocation()->getYaw() * 16 / 360) + 0.5)) & 0xf;
		}
		return parent::place($tx, $item, $blockReplace, $blockClicked, $face, $clickVector, $player);
	}

	public function asItem() : Item{
		return ItemFactory::getInstance()->get(ItemIds::SKULL, $this->skullType->getMagicNumber());
	}
}
