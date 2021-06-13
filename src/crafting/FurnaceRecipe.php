<?php

declare(strict_types=1);

namespace pocketmine\crafting;

use pocketmine\item\Item;

class FurnaceRecipe{

	/** @var Item */
	private $output;

	/** @var Item */
	private $ingredient;

	public function __construct(Item $result, Item $ingredient){
		$this->output = clone $result;
		$this->ingredient = clone $ingredient;
	}

	public function getInput() : Item{
		return clone $this->ingredient;
	}

	public function getResult() : Item{
		return clone $this->output;
	}
}
