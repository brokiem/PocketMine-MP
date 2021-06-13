<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types\recipe;

final class RecipeIngredient{

	/** @var int */
	private $id;
	/** @var int */
	private $meta;
	/** @var int */
	private $count;

	public function __construct(int $id, int $meta, int $count){
		$this->id = $id;
		$this->meta = $meta;
		$this->count = $count;
	}

	public function getId() : int{
		return $this->id;
	}

	public function getMeta() : int{
		return $this->meta;
	}

	public function getCount() : int{
		return $this->count;
	}
}
