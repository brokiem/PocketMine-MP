<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\block\tile\BrewingStand as TileBrewingStand;
use pocketmine\block\utils\BrewingStandSlot;
use pocketmine\item\Item;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use function array_key_exists;

class BrewingStand extends Transparent{

	/**
	 * @var BrewingStandSlot[]
	 * @phpstan-var array<int, BrewingStandSlot>
	 */
	protected array $slots = [];

	protected function writeStateToMeta() : int{
		$flags = 0;
		foreach([
			BlockLegacyMetadata::BREWING_STAND_FLAG_EAST => BrewingStandSlot::EAST(),
			BlockLegacyMetadata::BREWING_STAND_FLAG_NORTHWEST => BrewingStandSlot::NORTHWEST(),
			BlockLegacyMetadata::BREWING_STAND_FLAG_SOUTHWEST => BrewingStandSlot::SOUTHWEST(),
		] as $flag => $slot){
			$flags |= (array_key_exists($slot->id(), $this->slots) ? $flag : 0);
		}
		return $flags;
	}

	public function readStateFromData(int $id, int $stateMeta) : void{
		$this->slots = [];
		foreach([
			BlockLegacyMetadata::BREWING_STAND_FLAG_EAST => BrewingStandSlot::EAST(),
			BlockLegacyMetadata::BREWING_STAND_FLAG_NORTHWEST => BrewingStandSlot::NORTHWEST(),
			BlockLegacyMetadata::BREWING_STAND_FLAG_SOUTHWEST => BrewingStandSlot::SOUTHWEST(),
		] as $flag => $slot){
			if(($stateMeta & $flag) !== 0){
				$this->slots[$slot->id()] = $slot;
			}
		}
	}

	public function getStateBitmask() : int{
		return 0b111;
	}

	public function hasSlot(BrewingStandSlot $slot) : bool{
		return array_key_exists($slot->id(), $this->slots);
	}

	public function setSlot(BrewingStandSlot $slot, bool $occupied) : self{
		if($occupied){
			$this->slots[$slot->id()] = $slot;
		}else{
			unset($this->slots[$slot->id()]);
		}
		return $this;
	}

	/**
	 * @return BrewingStandSlot[]
	 * @phpstan-return array<int, BrewingStandSlot>
	 */
	public function getSlots() : array{
		return $this->slots;
	}

	/** @param BrewingStandSlot[] $slots */
	public function setSlots(array $slots) : self{
		$this->slots = [];
		foreach($slots as $slot){
			$this->slots[$slot->id()] = $slot;
		}
		return $this;
	}

	public function onInteract(Item $item, int $face, Vector3 $clickVector, ?Player $player = null) : bool{
		if($player instanceof Player){
			$stand = $this->pos->getWorld()->getTile($this->pos);
			if($stand instanceof TileBrewingStand and $stand->canOpenWith($item->getCustomName())){
				$player->setCurrentWindow($stand->getInventory());
			}
		}

		return true;
	}

	public function onScheduledUpdate() : void{
		//TODO
	}
}
