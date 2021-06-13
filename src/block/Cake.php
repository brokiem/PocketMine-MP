<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\block\utils\BlockDataSerializer;
use pocketmine\entity\effect\EffectInstance;
use pocketmine\entity\FoodSource;
use pocketmine\entity\Living;
use pocketmine\item\Item;
use pocketmine\math\AxisAlignedBB;
use pocketmine\math\Facing;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\world\BlockTransaction;

class Cake extends Transparent implements FoodSource{

	protected int $bites = 0;

	protected function writeStateToMeta() : int{
		return $this->bites;
	}

	public function readStateFromData(int $id, int $stateMeta) : void{
		$this->bites = BlockDataSerializer::readBoundedInt("bites", $stateMeta, 0, 6);
	}

	public function getStateBitmask() : int{
		return 0b111;
	}

	/**
	 * @return AxisAlignedBB[]
	 */
	protected function recalculateCollisionBoxes() : array{
		return [
			AxisAlignedBB::one()
				->contract(1 / 16, 0, 1 / 16)
				->trim(Facing::UP, 0.5)
				->trim(Facing::WEST, $this->bites / 8)
		];
	}

	public function getBites() : int{ return $this->bites; }

	/** @return $this */
	public function setBites(int $bites) : self{
		if($bites < 0 || $bites > 6){
			throw new \InvalidArgumentException("Bites must be in range 0-6");
		}
		$this->bites = $bites;
		return $this;
	}

	public function place(BlockTransaction $tx, Item $item, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector, ?Player $player = null) : bool{
		$down = $this->getSide(Facing::DOWN);
		if($down->getId() !== BlockLegacyIds::AIR){
			return parent::place($tx, $item, $blockReplace, $blockClicked, $face, $clickVector, $player);
		}

		return false;
	}

	public function onNearbyBlockChange() : void{
		if($this->getSide(Facing::DOWN)->getId() === BlockLegacyIds::AIR){ //Replace with common break method
			$this->pos->getWorld()->setBlock($this->pos, VanillaBlocks::AIR());
		}
	}

	public function getDropsForCompatibleTool(Item $item) : array{
		return [];
	}

	public function onInteract(Item $item, int $face, Vector3 $clickVector, ?Player $player = null) : bool{
		if($player !== null){
			$player->consumeObject($this);
			return true;
		}

		return false;
	}

	public function getFoodRestore() : int{
		return 2;
	}

	public function getSaturationRestore() : float{
		return 0.4;
	}

	public function requiresHunger() : bool{
		return true;
	}

	/**
	 * @return Block
	 */
	public function getResidue(){
		$clone = clone $this;
		$clone->bites++;
		if($clone->bites > 6){
			$clone = VanillaBlocks::AIR();
		}
		return $clone;
	}

	/**
	 * @return EffectInstance[]
	 */
	public function getAdditionalEffects() : array{
		return [];
	}

	public function onConsume(Living $consumer) : void{
		$this->pos->getWorld()->setBlock($this->pos, $this->getResidue());
	}
}
