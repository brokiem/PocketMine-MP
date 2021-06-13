<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\block\utils\BlockDataSerializer;
use pocketmine\block\utils\FacesOppositePlacingPlayerTrait;
use pocketmine\block\utils\HorizontalFacingTrait;
use pocketmine\math\AxisAlignedBB;
use pocketmine\math\Facing;

class EndPortalFrame extends Opaque{
	use FacesOppositePlacingPlayerTrait;
	use HorizontalFacingTrait;

	protected bool $eye = false;

	protected function writeStateToMeta() : int{
		return BlockDataSerializer::writeLegacyHorizontalFacing($this->facing) | ($this->eye ? BlockLegacyMetadata::END_PORTAL_FRAME_FLAG_EYE : 0);
	}

	public function readStateFromData(int $id, int $stateMeta) : void{
		$this->facing = BlockDataSerializer::readLegacyHorizontalFacing($stateMeta & 0x03);
		$this->eye = ($stateMeta & BlockLegacyMetadata::END_PORTAL_FRAME_FLAG_EYE) !== 0;
	}

	public function getStateBitmask() : int{
		return 0b111;
	}

	public function hasEye() : bool{ return $this->eye; }

	/** @return $this */
	public function setEye(bool $eye) : self{
		$this->eye = $eye;
		return $this;
	}

	public function getLightLevel() : int{
		return 1;
	}

	/**
	 * @return AxisAlignedBB[]
	 */
	protected function recalculateCollisionBoxes() : array{
		return [AxisAlignedBB::one()->trim(Facing::UP, 3 / 16)];
	}
}
