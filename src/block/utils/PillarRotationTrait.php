<?php

declare(strict_types=1);

namespace pocketmine\block\utils;

use pocketmine\block\Block;
use pocketmine\item\Item;
use pocketmine\math\Axis;
use pocketmine\math\Facing;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\world\BlockTransaction;

trait PillarRotationTrait{

	/** @var int */
	protected $axis = Axis::Y;

	/** @see Axis */
	public function getAxis() : int{ return $this->axis; }

	/** @return $this */
	public function setAxis(int $axis) : self{
		$this->axis = $axis;
		return $this;
	}

	/**
	 * @see Block::place()
	 */
	public function place(BlockTransaction $tx, Item $item, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector, ?Player $player = null) : bool{
		$this->axis = Facing::axis($face);
		/** @see Block::place() */
		return parent::place($tx, $item, $blockReplace, $blockClicked, $face, $clickVector, $player);
	}
}
