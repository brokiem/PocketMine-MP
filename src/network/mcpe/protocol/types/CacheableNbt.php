<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types;

use pocketmine\nbt\tag\Tag;
use pocketmine\nbt\TreeRoot;
use pocketmine\network\mcpe\protocol\serializer\NetworkNbtSerializer;

/**
 * @phpstan-template TTagType of Tag
 */
final class CacheableNbt{

	/**
	 * @var Tag
	 * @phpstan-var TTagType
	 */
	private $root;
	/** @var string|null */
	private $encodedNbt;

	/**
	 * @phpstan-param TTagType $nbtRoot
	 */
	public function __construct(Tag $nbtRoot){
		$this->root = $nbtRoot;
	}

	/**
	 * @phpstan-return TTagType
	 */
	public function getRoot() : Tag{
		return $this->root;
	}

	public function getEncodedNbt() : string{
		return $this->encodedNbt ?? ($this->encodedNbt = (new NetworkNbtSerializer())->write(new TreeRoot($this->root)));
	}
}
