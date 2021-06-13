<?php

declare(strict_types=1);

namespace pocketmine\world\format;

use function chr;
use function ord;
use function str_repeat;
use function strlen;

final class BiomeArray{

	/** @var string */
	private $payload;

	/**
	 * @param string $payload ZZZZXXXX key bits
	 */
	public function __construct(string $payload){
		if(strlen($payload) !== 256){
			throw new \InvalidArgumentException("Biome array is expected to be exactly 256 bytes");
		}
		$this->payload = $payload;
	}

	public static function fill(int $biomeId) : self{
		return new BiomeArray(str_repeat(chr($biomeId), 256));
	}

	private static function idx(int $x, int $z) : int{
		if($x < 0 or $x >= 16 or $z < 0 or $z >= 16){
			throw new \InvalidArgumentException("x and z must be in the range 0-15");
		}
		return ($z << 4) | $x;
	}

	public function get(int $x, int $z) : int{
		return ord($this->payload[self::idx($x, $z)]);
	}

	public function set(int $x, int $z, int $biomeId) : void{
		if($biomeId < 0 or $biomeId >= 256){
			throw new \InvalidArgumentException("Biome ID must be in the range 0-255");
		}
		$this->payload[self::idx($x, $z)] = chr($biomeId);
	}

	/**
	 * @return string ZZZZXXXX key bits
	 */
	public function getData() : string{
		return $this->payload;
	}
}
