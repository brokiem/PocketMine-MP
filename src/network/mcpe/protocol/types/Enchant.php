<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types;

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

final class Enchant{
	/** @var int */
	private $id;
	/** @var int */
	private $level;

	public function __construct(int $id, int $level){
		$this->id = $id;
		$this->level = $level;
	}

	public function getId() : int{ return $this->id; }

	public function getLevel() : int{ return $this->level; }

	public static function read(PacketSerializer $in) : self{
		$id = $in->getByte();
		$level = $in->getByte();
		return new self($id, $level);
	}

	public function write(PacketSerializer $out) : void{
		$out->putByte($this->id);
		$out->putByte($this->level);
	}
}
