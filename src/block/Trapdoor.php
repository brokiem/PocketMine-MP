<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\block\utils\BlockDataSerializer;
use pocketmine\block\utils\HorizontalFacingTrait;
use pocketmine\item\Item;
use pocketmine\math\AxisAlignedBB;
use pocketmine\math\Facing;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\world\BlockTransaction;
use pocketmine\world\sound\DoorSound;

class Trapdoor extends Transparent{
	use HorizontalFacingTrait;

	protected bool $open = false;
	protected bool $top = false;

	protected function writeStateToMeta() : int{
		return BlockDataSerializer::write5MinusHorizontalFacing($this->facing) | ($this->top ? BlockLegacyMetadata::TRAPDOOR_FLAG_UPPER : 0) | ($this->open ? BlockLegacyMetadata::TRAPDOOR_FLAG_OPEN : 0);
	}

	public function readStateFromData(int $id, int $stateMeta) : void{
		//TODO: in PC the values are reversed (facing - 2)

		$this->facing = BlockDataSerializer::read5MinusHorizontalFacing($stateMeta);
		$this->top = ($stateMeta & BlockLegacyMetadata::TRAPDOOR_FLAG_UPPER) !== 0;
		$this->open = ($stateMeta & BlockLegacyMetadata::TRAPDOOR_FLAG_OPEN) !== 0;
	}

	public function getStateBitmask() : int{
		return 0b1111;
	}

	public function isOpen() : bool{ return $this->open; }

	/** @return $this */
	public function setOpen(bool $open) : self{
		$this->open = $open;
		return $this;
	}

	public function isTop() : bool{ return $this->top; }

	/** @return $this */
	public function setTop(bool $top) : self{
		$this->top = $top;
		return $this;
	}

	/**
	 * @return AxisAlignedBB[]
	 */
	protected function recalculateCollisionBoxes() : array{
		return [AxisAlignedBB::one()->trim($this->open ? $this->facing : ($this->top ? Facing::DOWN : Facing::UP), 13 / 16)];
	}

	public function place(BlockTransaction $tx, Item $item, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector, ?Player $player = null) : bool{
		if($player !== null){
			$this->facing = Facing::opposite($player->getHorizontalFacing());
		}
		if(($clickVector->y > 0.5 and $face !== Facing::UP) or $face === Facing::DOWN){
			$this->top = true;
		}

		return parent::place($tx, $item, $blockReplace, $blockClicked, $face, $clickVector, $player);
	}

	public function onInteract(Item $item, int $face, Vector3 $clickVector, ?Player $player = null) : bool{
		$this->open = !$this->open;
		$this->pos->getWorld()->setBlock($this->pos, $this);
		$this->pos->getWorld()->addSound($this->pos, new DoorSound());
		return true;
	}
}
