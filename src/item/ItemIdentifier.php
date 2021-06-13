<?php

declare(strict_types=1);

namespace pocketmine\item;

final class ItemIdentifier{

	/** @var int */
	private $id;
	/** @var int */
	private $meta;

	public function __construct(int $id, int $meta){
		if($id < -0x8000 or $id > 0x7fff){ //signed short range
			throw new \InvalidArgumentException("ID must be in range " . -0x8000 . " - " . 0x7fff);
		}
		$this->id = $id;
		$this->meta = $meta !== -1 ? $meta & 0x7FFF : -1;
	}

	public function getId() : int{
		return $this->id;
	}

	public function getMeta() : int{
		return $this->meta;
	}
}
