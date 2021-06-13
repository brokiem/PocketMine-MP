<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\block\tile\Barrel as TileBarrel;
use pocketmine\block\utils\AnyFacingTrait;
use pocketmine\block\utils\BlockDataSerializer;
use pocketmine\item\Item;
use pocketmine\math\Facing;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\world\BlockTransaction;
use function abs;

class Barrel extends Opaque{
	use AnyFacingTrait;

	protected bool $open = false;

	protected function writeStateToMeta() : int{
		return BlockDataSerializer::writeFacing($this->facing) | ($this->open ? BlockLegacyMetadata::BARREL_FLAG_OPEN : 0);
	}

	public function readStateFromData(int $id, int $stateMeta) : void{
		$this->facing = BlockDataSerializer::readFacing($stateMeta & 0x07);
		$this->open = ($stateMeta & BlockLegacyMetadata::BARREL_FLAG_OPEN) === BlockLegacyMetadata::BARREL_FLAG_OPEN;
	}

	public function getStateBitmask() : int{
		return 0b1111;
	}

	public function isOpen() : bool{
		return $this->open;
	}

	/** @return $this */
	public function setOpen(bool $open) : Barrel{
		$this->open = $open;
		return $this;
	}

	public function place(BlockTransaction $tx, Item $item, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector, ?Player $player = null) : bool{
		if($player !== null){
			if(abs($player->getPosition()->getX() - $this->pos->getX()) < 2 && abs($player->getPosition()->getZ() - $this->pos->getZ()) < 2){
				$y = $player->getEyePos()->getY();

				if($y - $this->pos->getY() > 2){
					$this->facing = Facing::UP;
				}elseif($this->pos->getY() - $y > 0){
					$this->facing = Facing::DOWN;
				}else{
					$this->facing = Facing::opposite($player->getHorizontalFacing());
				}
			}else{
				$this->facing = Facing::opposite($player->getHorizontalFacing());
			}
		}

		return parent::place($tx, $item, $blockReplace, $blockClicked, $face, $clickVector, $player);
	}

	public function onInteract(Item $item, int $face, Vector3 $clickVector, ?Player $player = null) : bool{
		if($player instanceof Player){
			$barrel = $this->pos->getWorld()->getTile($this->pos);
			if($barrel instanceof TileBarrel){
				if(!$barrel->canOpenWith($item->getCustomName())){
					return true;
				}

				$player->setCurrentWindow($barrel->getInventory());
			}
		}

		return true;
	}

	public function getFuelTime() : int{
		return 300;
	}
}
