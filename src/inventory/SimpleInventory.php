<?php

declare(strict_types=1);

namespace pocketmine\inventory;

use pocketmine\item\Item;
use pocketmine\item\ItemFactory;

/**
 * This class provides a complete implementation of a regular inventory.
 */
class SimpleInventory extends BaseInventory{
	/**
	 * @var \SplFixedArray|(Item|null)[]
	 * @phpstan-var \SplFixedArray<Item|null>
	 */
	protected \SplFixedArray $slots;

	public function __construct(int $size){
		$this->slots = new \SplFixedArray($size);
		parent::__construct();
	}

	/**
	 * Returns the size of the inventory.
	 */
	public function getSize() : int{
		return $this->slots->getSize();
	}

	public function getItem(int $index) : Item{
		return $this->slots[$index] !== null ? clone $this->slots[$index] : ItemFactory::air();
	}

	/**
	 * @return Item[]
	 */
	public function getContents(bool $includeEmpty = false) : array{
		$contents = [];

		foreach($this->slots as $i => $slot){
			if($slot !== null){
				$contents[$i] = clone $slot;
			}elseif($includeEmpty){
				$contents[$i] = ItemFactory::air();
			}
		}

		return $contents;
	}

	protected function internalSetContents(array $items) : void{
		for($i = 0, $size = $this->getSize(); $i < $size; ++$i){
			if(!isset($items[$i])){
				$this->clear($i);
			}else{
				$this->setItem($i, $items[$i]);
			}
		}
	}

	protected function internalSetItem(int $index, Item $item) : void{
		$this->slots[$index] = $item->isNull() ? null : $item;
	}
}
