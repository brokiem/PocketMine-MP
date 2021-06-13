<?php

declare(strict_types=1);

namespace pocketmine\data\bedrock;

use pocketmine\block\utils\DyeColor;
use pocketmine\utils\SingletonTrait;

final class DyeColorIdMap{
	use SingletonTrait;

	/**
	 * @var DyeColor[]
	 * @phpstan-var array<int, DyeColor>
	 */
	private $idToEnum = [];

	/**
	 * @var int[]
	 * @phpstan-var array<int, int>
	 */
	private $enumToId = [];

	private function __construct(){
		$this->register(0, DyeColor::WHITE());
		$this->register(1, DyeColor::ORANGE());
		$this->register(2, DyeColor::MAGENTA());
		$this->register(3, DyeColor::LIGHT_BLUE());
		$this->register(4, DyeColor::YELLOW());
		$this->register(5, DyeColor::LIME());
		$this->register(6, DyeColor::PINK());
		$this->register(7, DyeColor::GRAY());
		$this->register(8, DyeColor::LIGHT_GRAY());
		$this->register(9, DyeColor::CYAN());
		$this->register(10, DyeColor::PURPLE());
		$this->register(11, DyeColor::BLUE());
		$this->register(12, DyeColor::BROWN());
		$this->register(13, DyeColor::GREEN());
		$this->register(14, DyeColor::RED());
		$this->register(15, DyeColor::BLACK());
	}

	private function register(int $id, DyeColor $color) : void{
		$this->idToEnum[$id] = $color;
		$this->enumToId[$color->id()] = $id;
	}

	public function toId(DyeColor $color) : int{
		return $this->enumToId[$color->id()]; //TODO: is it possible for this to be missing?
	}

	public function toInvertedId(DyeColor $color) : int{
		return ~$this->toId($color) & 0xf;
	}

	public function fromId(int $id) : ?DyeColor{
		return $this->idToEnum[$id];
	}

	public function fromInvertedId(int $id) : ?DyeColor{
		return $this->fromId(~$id & 0xf);
	}
}
