<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types\inventory\stackrequest;

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

trait DisappearStackRequestActionTrait{
	/** @var int */
	private $count;
	/** @var ItemStackRequestSlotInfo */
	private $source;

	final public function __construct(int $count, ItemStackRequestSlotInfo $source){
		$this->count = $count;
		$this->source = $source;
	}

	final public function getCount() : int{ return $this->count; }

	final public function getSource() : ItemStackRequestSlotInfo{ return $this->source; }

	public static function read(PacketSerializer $in) : self{
		$count = $in->getByte();
		$source = ItemStackRequestSlotInfo::read($in);
		return new self($count, $source);
	}

	public function write(PacketSerializer $out) : void{
		$out->putByte($this->count);
		$this->source->write($out);
	}
}
