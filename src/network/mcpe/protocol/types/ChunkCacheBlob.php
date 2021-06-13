<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types;

class ChunkCacheBlob{
	/** @var int */
	private $hash;
	/** @var string */
	private $payload;

	/**
	 * ChunkCacheBlob constructor.
	 */
	public function __construct(int $hash, string $payload){
		$this->hash = $hash;
		$this->payload = $payload;
	}

	public function getHash() : int{
		return $this->hash;
	}

	public function getPayload() : string{
		return $this->payload;
	}
}
