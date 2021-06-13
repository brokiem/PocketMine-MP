<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types\inventory;

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

final class CreativeContentEntry{

	/** @var int */
	private $entryId;
	/** @var ItemStack */
	private $item;

	public function __construct(int $entryId, ItemStack $item){
		$this->entryId = $entryId;
		$this->item = $item;
	}

	public function getEntryId() : int{ return $this->entryId; }

	public function getItem() : ItemStack{ return $this->item; }

	public static function read(PacketSerializer $in) : self{
		$entryId = $in->readGenericTypeNetworkId();
		$item = $in->getItemStackWithoutStackId();
		return new self($entryId, $item);
	}

	public function write(PacketSerializer $out) : void{
		$out->writeGenericTypeNetworkId($this->entryId);
		$out->putItemStackWithoutStackId($this->item);
	}
}
