<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\block\utils\BlockDataSerializer;
use pocketmine\block\utils\Fallable;
use pocketmine\block\utils\FallableTrait;
use pocketmine\item\Item;
use pocketmine\item\VanillaItems;
use pocketmine\math\AxisAlignedBB;
use pocketmine\math\Facing;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\world\BlockTransaction;
use function floor;
use function max;

class SnowLayer extends Flowable implements Fallable{
	use FallableTrait;

	protected int $layers = 1;

	protected function writeStateToMeta() : int{
		return $this->layers - 1;
	}

	public function readStateFromData(int $id, int $stateMeta) : void{
		$this->layers = BlockDataSerializer::readBoundedInt("layers", $stateMeta + 1, 1, 8);
	}

	public function getStateBitmask() : int{
		return 0b111;
	}

	public function getLayers() : int{ return $this->layers; }

	/** @return $this */
	public function setLayers(int $layers) : self{
		if($layers < 1 || $layers > 8){
			throw new \InvalidArgumentException("Layers must be in range 1-8");
		}
		$this->layers = $layers;
		return $this;
	}

	public function canBeReplaced() : bool{
		return $this->layers < 8;
	}

	/**
	 * @return AxisAlignedBB[]
	 */
	protected function recalculateCollisionBoxes() : array{
		//TODO: this zero-height BB is intended to stay in lockstep with a MCPE bug
		return [AxisAlignedBB::one()->trim(Facing::UP, $this->layers >= 4 ? 0.5 : 1)];
	}

	private function canBeSupportedBy(Block $b) : bool{
		return $b->isSolid() or ($b instanceof SnowLayer and $b->isSameType($this) and $b->layers === 8);
	}

	public function place(BlockTransaction $tx, Item $item, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector, ?Player $player = null) : bool{
		if($blockReplace instanceof SnowLayer){
			if($blockReplace->layers >= 8){
				return false;
			}
			$this->layers = $blockReplace->layers + 1;
		}
		if($this->canBeSupportedBy($blockReplace->getSide(Facing::DOWN))){
			return parent::place($tx, $item, $blockReplace, $blockClicked, $face, $clickVector, $player);
		}

		return false;
	}

	public function ticksRandomly() : bool{
		return true;
	}

	public function onRandomTick() : void{
		if($this->pos->getWorld()->getBlockLightAt($this->pos->x, $this->pos->y, $this->pos->z) >= 12){
			$this->pos->getWorld()->setBlock($this->pos, VanillaBlocks::AIR(), false);
		}
	}

	public function tickFalling() : ?Block{
		return null;
	}

	public function getDropsForCompatibleTool(Item $item) : array{
		return [
			VanillaItems::SNOWBALL()->setCount(max(1, (int) floor($this->layers / 2)))
		];
	}
}
