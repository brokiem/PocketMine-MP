<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\block\utils\AnyFacingTrait;
use pocketmine\block\utils\BlockDataSerializer;
use pocketmine\item\Item;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\world\BlockTransaction;
use pocketmine\world\sound\RedstonePowerOffSound;
use pocketmine\world\sound\RedstonePowerOnSound;

abstract class Button extends Flowable{
	use AnyFacingTrait;

	protected bool $pressed = false;

	protected function writeStateToMeta() : int{
		return BlockDataSerializer::writeFacing($this->facing) | ($this->pressed ? BlockLegacyMetadata::BUTTON_FLAG_POWERED : 0);
	}

	public function readStateFromData(int $id, int $stateMeta) : void{
		//TODO: in PC it's (6 - facing) for every meta except 0 (down)
		$this->facing = BlockDataSerializer::readFacing($stateMeta & 0x07);
		$this->pressed = ($stateMeta & BlockLegacyMetadata::BUTTON_FLAG_POWERED) !== 0;
	}

	public function getStateBitmask() : int{
		return 0b1111;
	}

	public function isPressed() : bool{ return $this->pressed; }

	/** @return $this */
	public function setPressed(bool $pressed) : self{
		$this->pressed = $pressed;
		return $this;
	}

	public function place(BlockTransaction $tx, Item $item, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector, ?Player $player = null) : bool{
		//TODO: check valid target block
		$this->facing = $face;
		return parent::place($tx, $item, $blockReplace, $blockClicked, $face, $clickVector, $player);
	}

	abstract protected function getActivationTime() : int;

	public function onInteract(Item $item, int $face, Vector3 $clickVector, ?Player $player = null) : bool{
		if(!$this->pressed){
			$this->pressed = true;
			$this->pos->getWorld()->setBlock($this->pos, $this);
			$this->pos->getWorld()->scheduleDelayedBlockUpdate($this->pos, $this->getActivationTime());
			$this->pos->getWorld()->addSound($this->pos->add(0.5, 0.5, 0.5), new RedstonePowerOnSound());
		}

		return true;
	}

	public function onScheduledUpdate() : void{
		if($this->pressed){
			$this->pressed = false;
			$this->pos->getWorld()->setBlock($this->pos, $this);
			$this->pos->getWorld()->addSound($this->pos->add(0.5, 0.5, 0.5), new RedstonePowerOffSound());
		}
	}
}
