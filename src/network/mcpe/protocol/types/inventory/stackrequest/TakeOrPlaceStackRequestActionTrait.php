<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types\inventory\stackrequest;

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

trait TakeOrPlaceStackRequestActionTrait{

	/** @var int */
	private $count;
	/** @var ItemStackRequestSlotInfo */
	private $source;
	/** @var ItemStackRequestSlotInfo */
	private $destination;

	final public function __construct(int $count, ItemStackRequestSlotInfo $source, ItemStackRequestSlotInfo $destination){
		$this->count = $count;
		$this->source = $source;
		$this->destination = $destination;
	}

	final public function getCount() : int{ return $this->count; }

	final public function getSource() : ItemStackRequestSlotInfo{ return $this->source; }

	final public function getDestination() : ItemStackRequestSlotInfo{ return $this->destination; }

	public static function read(PacketSerializer $in) : self{
		$count = $in->getByte();
		$src = ItemStackRequestSlotInfo::read($in);
		$dst = ItemStackRequestSlotInfo::read($in);
		return new self($count, $src, $dst);
	}

	public function write(PacketSerializer $out) : void{
		$out->putByte($this->count);
		$this->source->write($out);
		$this->destination->write($out);
	}
}
