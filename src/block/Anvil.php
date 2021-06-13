<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\block\inventory\AnvilInventory;
use pocketmine\block\utils\BlockDataSerializer;
use pocketmine\block\utils\Fallable;
use pocketmine\block\utils\FallableTrait;
use pocketmine\block\utils\HorizontalFacingTrait;
use pocketmine\item\Item;
use pocketmine\math\AxisAlignedBB;
use pocketmine\math\Facing;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\world\BlockTransaction;

class Anvil extends Transparent implements Fallable{
	use FallableTrait;
	use HorizontalFacingTrait;

	private int $damage = 0;

	protected function writeStateToMeta() : int{
		return BlockDataSerializer::writeLegacyHorizontalFacing($this->facing) | ($this->damage << 2);
	}

	public function readStateFromData(int $id, int $stateMeta) : void{
		$this->facing = BlockDataSerializer::readLegacyHorizontalFacing($stateMeta & 0x3);
		$this->damage = BlockDataSerializer::readBoundedInt("damage", $stateMeta >> 2, 0, 2);
	}

	public function getStateBitmask() : int{
		return 0b1111;
	}

	public function getNonPersistentStateBitmask() : int{
		return 0b11;
	}

	public function getDamage() : int{ return $this->damage; }

	/** @return $this */
	public function setDamage(int $damage) : self{
		if($damage < 0 || $damage > 2){
			throw new \InvalidArgumentException("Damage must be in range 0-2");
		}
		$this->damage = $damage;
		return $this;
	}

	/**
	 * @return AxisAlignedBB[]
	 */
	protected function recalculateCollisionBoxes() : array{
		return [AxisAlignedBB::one()->squash(Facing::axis(Facing::rotateY($this->facing, false)), 1 / 8)];
	}

	public function onInteract(Item $item, int $face, Vector3 $clickVector, ?Player $player = null) : bool{
		if($player instanceof Player){
			$player->setCurrentWindow(new AnvilInventory($this->pos));
		}

		return true;
	}

	public function place(BlockTransaction $tx, Item $item, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector, ?Player $player = null) : bool{
		if($player !== null){
			$this->facing = Facing::rotateY($player->getHorizontalFacing(), true);
		}
		return parent::place($tx, $item, $blockReplace, $blockClicked, $face, $clickVector, $player);
	}

	public function tickFalling() : ?Block{
		return null;
	}
}
