<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types\inventory\stackrequest;

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

/**
 * Drops some (or all) items from the source slot into the world as an item entity.
 */
final class DropStackRequestAction extends ItemStackRequestAction{

	/** @var int */
	private $count;
	/** @var ItemStackRequestSlotInfo */
	private $source;
	/** @var bool */
	private $randomly;

	public function __construct(int $count, ItemStackRequestSlotInfo $source, bool $randomly){
		$this->count = $count;
		$this->source = $source;
		$this->randomly = $randomly;
	}

	public function getCount() : int{ return $this->count; }

	public function getSource() : ItemStackRequestSlotInfo{ return $this->source; }

	public function isRandomly() : bool{ return $this->randomly; }

	public static function getTypeId() : int{ return ItemStackRequestActionType::DROP; }

	public static function read(PacketSerializer $in) : self{
		$count = $in->getByte();
		$source = ItemStackRequestSlotInfo::read($in);
		$random = $in->getBool();
		return new self($count, $source, $random);
	}

	public function write(PacketSerializer $out) : void{
		$out->putByte($this->count);
		$this->source->write($out);
		$out->putBool($this->randomly);
	}
}
