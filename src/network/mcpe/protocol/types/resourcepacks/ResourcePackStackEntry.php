<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types\resourcepacks;

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class ResourcePackStackEntry{

	/** @var string */
	private $packId;
	/** @var string */
	private $version;
	/** @var string */
	private $subPackName;

	public function __construct(string $packId, string $version, string $subPackName){
		$this->packId = $packId;
		$this->version = $version;
		$this->subPackName = $subPackName;
	}

	public function getPackId() : string{
		return $this->packId;
	}

	public function getVersion() : string{
		return $this->version;
	}

	public function getSubPackName() : string{
		return $this->subPackName;
	}

	public function write(PacketSerializer $out) : void{
		$out->putString($this->packId);
		$out->putString($this->version);
		$out->putString($this->subPackName);
	}

	public static function read(PacketSerializer $in) : self{
		$packId = $in->getString();
		$version = $in->getString();
		$subPackName = $in->getString();
		return new self($packId, $version, $subPackName);
	}
}
