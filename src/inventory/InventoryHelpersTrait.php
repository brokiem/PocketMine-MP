<?php

declare(strict_types=1);

namespace pocketmine\inventory;

use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use function count;
use function max;
use function min;

trait InventoryHelpersTrait{

	abstract public function getMaxStackSize() : int;
	abstract public function getSize() : int;
	abstract public function getItem(int $index) : Item;
	abstract public function setItem(int $index, Item $item) : void;

	/**
	 * @return Item[]
	 */
	abstract public function getContents(bool $includeEmpty = false) : array;

	/**
	 * @param Item[] $items
	 */
	abstract public function setContents(array $items) : void;

	public function contains(Item $item) : bool{
		$count = max(1, $item->getCount());
		$checkDamage = !$item->hasAnyDamageValue();
		$checkTags = $item->hasNamedTag();
		foreach($this->getContents() as $i){
			if($item->equals($i, $checkDamage, $checkTags)){
				$count -= $i->getCount();
				if($count <= 0){
					return true;
				}
			}
		}

		return false;
	}

	public function all(Item $item) : array{
		$slots = [];
		$checkDamage = !$item->hasAnyDamageValue();
		$checkTags = $item->hasNamedTag();
		foreach($this->getContents() as $index => $i){
			if($item->equals($i, $checkDamage, $checkTags)){
				$slots[$index] = $i;
			}
		}

		return $slots;
	}

	public function remove(Item $item) : void{
		$checkDamage = !$item->hasAnyDamageValue();
		$checkTags = $item->hasNamedTag();

		foreach($this->getContents() as $index => $i){
			if($item->equals($i, $checkDamage, $checkTags)){
				$this->clear($index);
			}
		}
	}

	public function first(Item $item, bool $exact = false) : int{
		$count = $exact ? $item->getCount() : max(1, $item->getCount());
		$checkDamage = $exact || !$item->hasAnyDamageValue();
		$checkTags = $exact || $item->hasNamedTag();

		foreach($this->getContents() as $index => $i){
			if($item->equals($i, $checkDamage, $checkTags) and ($i->getCount() === $count or (!$exact and $i->getCount() > $count))){
				return $index;
			}
		}

		return -1;
	}

	public function firstEmpty() : int{
		foreach($this->getContents(true) as $i => $slot){
			if($slot->isNull()){
				return $i;
			}
		}

		return -1;
	}

	public function isSlotEmpty(int $index) : bool{
		return $this->getItem($index)->isNull();
	}

	public function canAddItem(Item $item) : bool{
		$count = $item->getCount();
		for($i = 0, $size = $this->getSize(); $i < $size; ++$i){
			$slot = $this->getItem($i);
			if($item->equals($slot)){
				if(($diff = min($slot->getMaxStackSize(), $item->getMaxStackSize()) - $slot->getCount()) > 0){
					$count -= $diff;
				}
			}elseif($slot->isNull()){
				$count -= min($this->getMaxStackSize(), $item->getMaxStackSize());
			}

			if($count <= 0){
				return true;
			}
		}

		return false;
	}

	public function addItem(Item ...$slots) : array{
		/** @var Item[] $itemSlots */
		/** @var Item[] $slots */
		$itemSlots = [];
		foreach($slots as $slot){
			if(!$slot->isNull()){
				$itemSlots[] = clone $slot;
			}
		}

		/** @var Item[] $returnSlots */
		$returnSlots = [];

		foreach($itemSlots as $item){
			$leftover = $this->internalAddItem($item);
			if(!$leftover->isNull()){
				$returnSlots[] = $leftover;
			}
		}

		return $returnSlots;
	}

	private function internalAddItem(Item $slot) : Item{
		$emptySlots = [];

		for($i = 0, $size = $this->getSize(); $i < $size; ++$i){
			$item = $this->getItem($i);
			if($item->isNull()){
				$emptySlots[] = $i;
			}

			if($slot->equals($item) and $item->getCount() < $item->getMaxStackSize()){
				$amount = min($item->getMaxStackSize() - $item->getCount(), $slot->getCount(), $this->getMaxStackSize());
				if($amount > 0){
					$slot->setCount($slot->getCount() - $amount);
					$item->setCount($item->getCount() + $amount);
					$this->setItem($i, $item);
					if($slot->getCount() <= 0){
						break;
					}
				}
			}
		}

		if(count($emptySlots) > 0){
			foreach($emptySlots as $slotIndex){
				$amount = min($slot->getMaxStackSize(), $slot->getCount(), $this->getMaxStackSize());
				$slot->setCount($slot->getCount() - $amount);
				$item = clone $slot;
				$item->setCount($amount);
				$this->setItem($slotIndex, $item);
				break;
			}
		}

		return $slot;
	}

	public function removeItem(Item ...$slots) : array{
		/** @var Item[] $itemSlots */
		/** @var Item[] $slots */
		$itemSlots = [];
		foreach($slots as $slot){
			if(!$slot->isNull()){
				$itemSlots[] = clone $slot;
			}
		}

		for($i = 0, $size = $this->getSize(); $i < $size; ++$i){
			$item = $this->getItem($i);
			if($item->isNull()){
				continue;
			}

			foreach($itemSlots as $index => $slot){
				if($slot->equals($item, !$slot->hasAnyDamageValue(), $slot->hasNamedTag())){
					$amount = min($item->getCount(), $slot->getCount());
					$slot->setCount($slot->getCount() - $amount);
					$item->setCount($item->getCount() - $amount);
					$this->setItem($i, $item);
					if($slot->getCount() <= 0){
						unset($itemSlots[$index]);
					}
				}
			}

			if(count($itemSlots) === 0){
				break;
			}
		}

		return $itemSlots;
	}

	public function clear(int $index) : void{
		$this->setItem($index, ItemFactory::air());
	}

	public function clearAll() : void{
		$this->setContents([]);
	}

	public function swap(int $slot1, int $slot2) : void{
		$i1 = $this->getItem($slot1);
		$i2 = $this->getItem($slot2);
		$this->setItem($slot1, $i2);
		$this->setItem($slot2, $i1);
	}
}
