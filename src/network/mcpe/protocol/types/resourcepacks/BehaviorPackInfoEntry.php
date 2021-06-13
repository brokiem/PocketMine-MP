<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types\resourcepacks;

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class BehaviorPackInfoEntry{

	/** @var string */
	private $packId;
	/** @var string */
	private $version;
	/** @var int */
	private $sizeBytes;
	/** @var string */
	private $encryptionKey;
	/** @var string */
	private $subPackName;
	/** @var string */
	private $contentId;
	/** @var bool */
	private $hasScripts;

	public function __construct(string $packId, string $version, int $sizeBytes, string $encryptionKey = "", string $subPackName = "", string $contentId = "", bool $hasScripts = false){
		$this->packId = $packId;
		$this->version = $version;
		$this->sizeBytes = $sizeBytes;
		$this->encryptionKey = $encryptionKey;
		$this->subPackName = $subPackName;
		$this->contentId = $contentId;
		$this->hasScripts = $hasScripts;
	}

	public function getPackId() : string{
		return $this->packId;
	}

	public function getVersion() : string{
		return $this->version;
	}

	public function getSizeBytes() : int{
		return $this->sizeBytes;
	}

	public function getEncryptionKey() : string{
		return $this->encryptionKey;
	}

	public function getSubPackName() : string{
		return $this->subPackName;
	}

	public function getContentId() : string{
		return $this->contentId;
	}

	public function hasScripts() : bool{
		return $this->hasScripts;
	}

	public function write(PacketSerializer $out) : void{
		$out->putString($this->packId);
		$out->putString($this->version);
		$out->putLLong($this->sizeBytes);
		$out->putString($this->encryptionKey);
		$out->putString($this->subPackName);
		$out->putString($this->contentId);
		$out->putBool($this->hasScripts);
	}

	public static function read(PacketSerializer $in) : self{
		$uuid = $in->getString();
		$version = $in->getString();
		$sizeBytes = $in->getLLong();
		$encryptionKey = $in->getString();
		$subPackName = $in->getString();
		$contentId = $in->getString();
		$hasScripts = $in->getBool();
		return new self($uuid, $version, $sizeBytes, $encryptionKey, $subPackName, $contentId, $hasScripts);
	}
}
