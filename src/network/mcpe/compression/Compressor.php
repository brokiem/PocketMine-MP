<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\compression;

interface Compressor{

	public function willCompress(string $data) : bool;

	/**
	 * @throws DecompressionException
	 */
	public function decompress(string $payload) : string;

	public function compress(string $payload) : string;
}