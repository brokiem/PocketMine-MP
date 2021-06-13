<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\entity\Entity;
use pocketmine\item\Item;
use pocketmine\math\Axis;
use pocketmine\math\AxisAlignedBB;

class NetherPortal extends Transparent{

	protected int $axis = Axis::X;

	public function readStateFromData(int $id, int $stateMeta) : void{
		$this->axis = $stateMeta === BlockLegacyMetadata::NETHER_PORTAL_AXIS_Z ? Axis::Z : Axis::X; //mojang u dumb
	}

	protected function writeStateToMeta() : int{
		return $this->axis === Axis::Z ? BlockLegacyMetadata::NETHER_PORTAL_AXIS_Z : BlockLegacyMetadata::NETHER_PORTAL_AXIS_X;
	}

	public function getStateBitmask() : int{
		return 0b11;
	}

	public function getAxis() : int{
		return $this->axis;
	}

	/**
	 * @throws \InvalidArgumentException
	 * @return $this
	 */
	public function setAxis(int $axis) : self{
		if($axis !== Axis::X and $axis !== Axis::Z){
			throw new \InvalidArgumentException("Invalid axis");
		}
		$this->axis = $axis;
		return $this;
	}

	public function getLightLevel() : int{
		return 11;
	}

	public function isSolid() : bool{
		return false;
	}

	/**
	 * @return AxisAlignedBB[]
	 */
	protected function recalculateCollisionBoxes() : array{
		return [];
	}

	public function getDrops(Item $item) : array{
		return [];
	}

	public function onEntityInside(Entity $entity) : bool{
		//TODO
		return true;
	}
}
