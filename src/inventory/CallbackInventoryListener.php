<?php

declare(strict_types=1);

namespace pocketmine\inventory;

use pocketmine\item\Item;
use pocketmine\utils\Utils;

class CallbackInventoryListener implements InventoryListener{

	//TODO: turn the closure signatures into type aliases when PHPStan supports them

	/**
	 * @var \Closure|null
	 * @phpstan-var (\Closure(Inventory, int, Item) : void)|null
	 */
	private $onSlotChangeCallback;
	/**
	 * @var \Closure|null
	 * @phpstan-var (\Closure(Inventory, Item[]) : void)|null
	 */
	private $onContentChangeCallback;

	/**
	 * @phpstan-param (\Closure(Inventory, int, Item) : void)|null $onSlotChange
	 * @phpstan-param (\Closure(Inventory, Item[]) : void)|null $onContentChange
	 */
	public function __construct(?\Closure $onSlotChange, ?\Closure $onContentChange){
		if($onSlotChange !== null){
			Utils::validateCallableSignature(function(Inventory $inventory, int $slot, Item $oldItem) : void{}, $onSlotChange);
		}
		if($onContentChange !== null){
			Utils::validateCallableSignature(function(Inventory $inventory, array $oldContents) : void{}, $onContentChange);
		}

		$this->onSlotChangeCallback = $onSlotChange;
		$this->onContentChangeCallback = $onContentChange;
	}

	/**
	 * @phpstan-param \Closure(Inventory) : void $onChange
	 */
	public static function onAnyChange(\Closure $onChange) : self{
		return new self(
			static function(Inventory $inventory, int $unused, Item $unusedB) use ($onChange) : void{
				$onChange($inventory);
			},
			static function(Inventory $inventory, array $unused) use ($onChange) : void{
				$onChange($inventory);
			}
		);
	}

	public function onSlotChange(Inventory $inventory, int $slot, Item $oldItem) : void{
		if($this->onSlotChangeCallback !== null){
			($this->onSlotChangeCallback)($inventory, $slot, $oldItem);
		}
	}

	/**
	 * @param Item[] $oldContents
	 */
	public function onContentChange(Inventory $inventory, array $oldContents) : void{
		if($this->onContentChangeCallback !== null){
			($this->onContentChangeCallback)($inventory, $oldContents);
		}
	}
}
