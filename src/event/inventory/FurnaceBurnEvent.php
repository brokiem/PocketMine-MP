<?php

declare(strict_types=1);

namespace pocketmine\event\inventory;

use pocketmine\block\tile\Furnace;
use pocketmine\event\block\BlockEvent;
use pocketmine\event\Cancellable;
use pocketmine\event\CancellableTrait;
use pocketmine\item\Item;

/**
 * Called when a furnace is about to consume a new fuel item.
 */
class FurnaceBurnEvent extends BlockEvent implements Cancellable{
	use CancellableTrait;

	/** @var Furnace */
	private $furnace;
	/** @var Item */
	private $fuel;
	/** @var int */
	private $burnTime;
	/** @var bool */
	private $burning = true;

	public function __construct(Furnace $furnace, Item $fuel, int $burnTime){
		parent::__construct($furnace->getBlock());
		$this->fuel = $fuel;
		$this->burnTime = $burnTime;
		$this->furnace = $furnace;
	}

	public function getFurnace() : Furnace{
		return $this->furnace;
	}

	public function getFuel() : Item{
		return $this->fuel;
	}

	/**
	 * Returns the number of ticks that the furnace will be powered for.
	 */
	public function getBurnTime() : int{
		return $this->burnTime;
	}

	/**
	 * Sets the number of ticks that the given fuel will power the furnace for.
	 */
	public function setBurnTime(int $burnTime) : void{
		$this->burnTime = $burnTime;
	}

	/**
	 * Returns whether the fuel item will be consumed.
	 */
	public function isBurning() : bool{
		return $this->burning;
	}

	/**
	 * Sets whether the fuel will be consumed. If false, the furnace will smelt as if it consumed fuel, but no fuel
	 * will be deducted.
	 */
	public function setBurning(bool $burning) : void{
		$this->burning = $burning;
	}
}
