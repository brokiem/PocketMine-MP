<?php

declare(strict_types=1);

namespace pocketmine\inventory;

use pocketmine\item\Durable;
use pocketmine\item\Item;
use pocketmine\utils\SingletonTrait;
use Webmozart\PathUtil\Path;
use function file_get_contents;
use function json_decode;

final class CreativeInventory{
	use SingletonTrait;

	/** @var Item[] */
	private $creative = [];

	private function __construct(){
		$creativeItems = json_decode(file_get_contents(Path::join(\pocketmine\RESOURCE_PATH, "vanilla", "creativeitems.json")), true);

		foreach($creativeItems as $data){
			$item = Item::jsonDeserialize($data);
			if($item->getName() === "Unknown"){
				continue;
			}
			$this->add($item);
		}
	}

	/**
	 * Removes all previously added items from the creative menu.
	 * Note: Players who are already online when this is called will not see this change.
	 */
	public function clear() : void{
		$this->creative = [];
	}

	/**
	 * @return Item[]
	 */
	public function getAll() : array{
		return $this->creative;
	}

	public function getItem(int $index) : ?Item{
		return $this->creative[$index] ?? null;
	}

	public function getItemIndex(Item $item) : int{
		foreach($this->creative as $i => $d){
			if($item->equals($d, !($item instanceof Durable))){
				return $i;
			}
		}

		return -1;
	}

	/**
	 * Adds an item to the creative menu.
	 * Note: Players who are already online when this is called will not see this change.
	 */
	public function add(Item $item) : void{
		$this->creative[] = clone $item;
	}

	/**
	 * Removes an item from the creative menu.
	 * Note: Players who are already online when this is called will not see this change.
	 */
	public function remove(Item $item) : void{
		$index = $this->getItemIndex($item);
		if($index !== -1){
			unset($this->creative[$index]);
		}
	}

	public function contains(Item $item) : bool{
		return $this->getItemIndex($item) !== -1;
	}
}
